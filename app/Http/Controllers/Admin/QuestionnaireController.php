<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadQuestionnaireResultsRequest;
use App\Imports\Sheets\AnswersImport;
use App\Imports\Sheets\FormScannerImport;
use App\Imports\Sheets\TagQuestionsImport;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class QuestionnaireController extends Controller
{
    public function importResults(UploadQuestionnaireResultsRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        $shouldImportFormScanner = $request->file('file_formscanner') !== null;
        $shouldImportMoodleGrades = $request->file('file_grades') !== null;
        $shouldImportMoodleAnswers = $request->file('file_answers') !== null;
        $shouldImportTags = $request->file('file_tags') !== null;

        $shouldImport = $shouldImportFormScanner || $shouldImportMoodleGrades || $shouldImportMoodleAnswers || $shouldImportTags;

        if (!$shouldImport) {
            return redirect()->route('filament.resources.questionnaires.upload', ['record' => $questionnaire])
                ->withErrors('No hay archivos para importar');
        }

        $result = QuestionnaireImportAnswersResult::create([
            'questionnaire_id' => $questionnaire->id,
            'data' => [],
            'log' => [],
        ]);

        if ($questionnaire->questions->count() === 0) {
            $result->insertIntoLog('Question count is 0, creating questions');

            $this->createQuestions($questionnaire, $request->questions);
        } elseif ($questionnaire->questions->count() != $request->questions) {
            $result->insertIntoLog('Question count mismatch');

            return redirect()->route('filament.resources.questionnaires.upload', ['record' => $questionnaire])
                ->withErrors('El número de preguntas no coincide con el número de preguntas del ensayo');
        }

        $result->insertIntoLog('Import queued at ' . now()->toDateTimeString());

        if ($shouldImportFormScanner) {
            $result->insertIntoLog('Queuing FormScanner CSV import');

            Excel::import(
                new FormScannerImport($questionnaire->id, $result->id),
                $request->file('file_formscanner'), // @phpstan-ignore-line
            );
        }

        if ($shouldImportMoodleAnswers) {
            $result->insertIntoLog('Queuing Moodle Answers import');

            Excel::import(
                new AnswersImport($questionnaire->id, $result->id),
                $request->file('file_answers'), // @phpstan-ignore-line
            );
        }

        if ($shouldImportTags) {
            $result->insertIntoLog('Queuing tags import');

            Excel::import(
                new TagQuestionsImport($questionnaire->id, $result->id),
                $request->file('file_tags') // @phpstan-ignore-line
            );
        }

        return redirect()->route('filament.resources.questionnaires.upload-results', [$questionnaire, $result]);
    }

    private function createQuestions(Questionnaire $questionnaire, int $count): void
    {
        for ($i = 1; $i <= $count; ++$i) {
            $question = Question::create([
                'questionnaire_id' => $questionnaire->id,
                'position' => $i,
            ]);

            $question->alternatives()->createMany([
                ['position' => 1, 'name' => 'A', 'correct' => false],
                ['position' => 2, 'name' => 'B', 'correct' => false],
                ['position' => 3, 'name' => 'C', 'correct' => false],
                ['position' => 4, 'name' => 'D', 'correct' => false],
                ['position' => 5, 'name' => 'E', 'correct' => false],
                ['position' => 6, 'name' => 'N/A', 'correct' => false],
            ]);
        }
    }
}
