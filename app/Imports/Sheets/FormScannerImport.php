<?php

namespace App\Imports\Sheets;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use App\Models\Student;
use App\Models\User;
use App\Utils\Rut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Row;

class FormScannerImport implements OnEachRow, WithHeadingRow, WithValidation, WithChunkReading, WithEvents, ShouldQueue
{
    public const QUESTION_COLUMN = 'respuestas';
    public const RUT_COLUMN_NAME = 'idid_';

    public function __construct(
        public Questionnaire $questionnaire,
        public QuestionnaireImportAnswersResult $results
    ) {
        //
    }

    public function onRow(Row $row): void
    {
        $row = $row->toArray();

        $student = User::inRandomOrder()->firstOrFail();

        $rut = Rut::fromArray($this->getRut($row));

        $studentResult = $this->results->createChild('Processing rut '.$rut, ['rut' => $rut]);

        if (!$rut->isValid()) {
            $studentResult->insertIntoLog('Invalid rut');
            $studentResult->setResult('error');

            return;
        }

        try {
            $student = User::whereRut($rut->getRut())->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $studentResult->insertIntoLog('User with rut not found');
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

        $questionsCount = $this->questionnaire->questions()->count();

        $studentResult->insertIntoLog('Processing questions');
        DB::transaction(function () use ($row, $student, $questionsCount, $studentResult) {
            for ($i = 0; $i < $questionsCount; ++$i) {
                try {
                    $question = $this->questionnaire->questions()->wherePosition($i)->firstOrFail();
                } catch (\Throwable  $e) {
                    continue;
                }

                $questionResult = $studentResult->createChild('Processing question '.$i + 1, question: $question); // @phpstan-ignore-line

                $columnName = self::QUESTION_COLUMN.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);

                $marked = $row[$columnName];

                $questionResult->insertIntoLog('Marked: '.$marked);

                try {
                    $student->detachAlternativesFromQuestion($question);
                } catch (\Throwable  $e) {
                    continue;
                }

                if ($marked == null) {
                    $this->attachToDefaultAlternative($student, $question, $questionResult);

                    continue;
                }

                try {
                    $alternative = $question->alternatives()->whereName($marked)->firstOrFail();
                    $this->attachToAlternative($student, $alternative, $questionResult);
                } catch (\Throwable $e) {
                    $this->attachToDefaultAlternative($student, $question, $questionResult);
                }
            }
        });

        $studentResult->insertIntoLog('Questions processed');
        $studentResult->setResult('success');
    }

    private function attachToDefaultAlternative(Student $student, Question $question, QuestionnaireImportAnswersResult $questionResult): void
    {
        try {
            $alternative = $question->alternatives()->whereName('N/A')->firstOrFail();
            $this->attachToAlternative($student, $alternative, $questionResult);
        } catch (\Throwable  $e) {
            //
        }
    }

    private function attachToAlternative(Student $student, Alternative $alternative, QuestionnaireImportAnswersResult $questionResult): void
    {
        $student->attachAlternative($alternative);
        $questionResult->insertIntoLog('Attached to '.$alternative->name);
        $questionResult->insertIntoData(['alternative_id' => $alternative->id]);
        $questionResult->setResult('success');
    }

    private function getRut(array $row): array
    {
        $rut = '';

        for ($i = 1; $i <= 8; ++$i) {
            $columnName = self::RUT_COLUMN_NAME.str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $rut .= $row[$columnName];
        }

        $rutDv = $row[self::RUT_COLUMN_NAME.'dv'];

        return [$rut, $rutDv];
    }

    public function rules(): array
    {
        // $questionCount = 80;
        // $validations = [];

        // for ($i = 1; $i <= $questionCount; ++$i) {
        //     $validations[self::QUESTION_COLUMN . str_pad((string) $i, 2, '0', STR_PAD_LEFT)] = 'nullable|string';
        // }

        // return array_merge($validations, [
        //     'file_name' => 'required|string',
        // ]);
        return [];
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                // $this->importedBy->notify(new ImportHasFailedNotification);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
