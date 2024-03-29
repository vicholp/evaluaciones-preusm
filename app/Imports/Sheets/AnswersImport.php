<?php

namespace App\Imports\Sheets;

use App\Jobs\Services\Stats\ComputeStudentStatsForQuestionnaireJob;
use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

/**
 * Imports .xlsx files generated by Moodle, with the answers of the students.
 */
class AnswersImport implements ShouldQueue, WithChunkReading, WithHeadingRow, OnEachRow, WithEvents
{
    public const QUESTION_COLUMN = 'respuesta_';
    public const EMAIL_COLUMN_NAME = 'direccion_de_correo';

    private Questionnaire $questionnaire;
    private QuestionnaireImportAnswersResult $results;

    public function __construct(
        private int $questionnaireId,
        private int $resultsId
    ) {
        //
    }

    public function onRow(Row $fullRow): void
    {
        $this->questionnaire = Questionnaire::with('questions')->findOrFail($this->questionnaireId);
        $this->results = QuestionnaireImportAnswersResult::findOrFail($this->resultsId);

        $row = $fullRow->toArray();

        $email = $row[self::EMAIL_COLUMN_NAME];

        $studentResult = $this->results->createChild('Processing email ' . $email, ['email' => $email]);

        try {
            $student = User::whereEmail($email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $studentResult->insertIntoLog('User with email not found');
            $studentResult->setResult('error');

            return;
        }

        $student = $student->student;

        if ($student == null) {
            $studentResult->insertIntoLog('User does not have a student profile');
            $studentResult->setResult('error');

            return;
        }

        $studentResult->insertIntoLog('Student found', student: $student);

        $questionsCount = $this->questionnaire->questions->count();

        $studentResult->insertIntoLog('Processing questions');

        DB::transaction(function () use ($row, $student, $questionsCount, $studentResult) {
            for ($i = 0; $i < $questionsCount; ++$i) {
                try {
                    $question = $this->questionnaire->questions()->wherePosition($i + 1)->firstOrFail();
                } catch (\Throwable  $e) {
                    $studentResult->insertIntoLog('Question not found at position ' . $i + 1);  // @phpstan-ignore-line
                    $studentResult->setResult('error');

                    break;
                }

                $questionResult = $studentResult->createChild('Processing question ' . $i + 1, question: $question); // @phpstan-ignore-line

                $columnName = self::QUESTION_COLUMN . ($i + 1);

                $marked = $row[$columnName];

                $questionResult->insertIntoLog('Marked: ' . $marked);

                try {
                    $student->detachAlternativesFromQuestion($question);
                } catch (\Throwable  $e) {
                    $questionResult->insertIntoLog('Failed to detatch. Ending process');
                    $studentResult->setResult('error');
                    break;
                }

                if ($marked == null || $marked == '-') {
                    $this->attachToDefaultAlternative($student, $question, $questionResult);

                    continue;
                }

                try {
                    $alternative = $question->alternatives()->whereName($marked)->firstOrFail();

                    $this->attachToAlternative($student, $alternative, $questionResult);
                } catch (\Throwable $e) {
                    $questionResult->insertIntoLog('Failed to attach to ' . $marked . ', attaching to default');
                    $studentResult->setResult('error');

                    $this->attachToDefaultAlternative($student, $question, $questionResult);

                    break;
                }
            }
        });

        $studentResult->insertIntoLog('Questions processed');
        $studentResult->setResult('success');

        // ComputeStudentStatsForQuestionnaireJob::dispatch($student, $this->questionnaire);
    }

    private function attachToDefaultAlternative(Student $student, Question $question, QuestionnaireImportAnswersResult $questionResult): void
    {
        try {
            $alternative = $question->alternatives()->whereName('N/A')->firstOrFail();
            $this->attachToAlternative($student, $alternative, $questionResult);
        } catch (\Throwable  $e) {
            $questionResult->insertIntoLog('Failed to attach to default');
        }
    }

    public function registerEvents(): array
    {
        return [];
    }

    private function attachToAlternative(Student $student, Alternative $alternative, QuestionnaireImportAnswersResult $questionResult): void
    {
        $student->attachAlternative($alternative);
        $questionResult->insertIntoLog('Attached to ' . $alternative->name);
        $questionResult->insertIntoData('alternative_id', $alternative->id);
        $questionResult->setResult('success');
    }

    public function chunkSize(): int
    {
        return 3;
    }
}
