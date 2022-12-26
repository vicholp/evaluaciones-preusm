<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadQuestionnaireResultsRequest;
use App\Imports\QuestionnaireImport;
use App\Imports\Sheets\AnswersImport;
use App\Imports\Sheets\FormScannerImport;
use App\Imports\Sheets\GradesImport;
use App\Imports\Sheets\TagQuestionsImport;
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
            return redirect()->route('filament.resources.questionnaires.show', ['questionnaire' => $questionnaire]);
        }

        $result = QuestionnaireImportAnswersResult::create([
            'questionnaire_id' => $questionnaire->id,
            'data' => [],
            'log' => [],
        ]);

        $result->insertIntoLog('Import queued at ' . now()->toDateTimeString());

        if ($shouldImportFormScanner) {
            Excel::import(new FormScannerImport($questionnaire, $result), $request->file('file_formscanner')); // @phpstan-ignore-line
        }

        // if ($shouldImportMoodleAnswers) {
        //     Excel::import(new AnswersImport($questionnaire->id, $result), $request->file('file_answers'));
        // }

        // if ($shouldImportMoodleGrades) {
        //     Excel::import(new GradesImport($questionnaire->id, $result), $request->file('file_grades'));
        // }

        if ($shouldImportTags) {
            Excel::import(new TagQuestionsImport($questionnaire->id, $result), $request->file('file_tags')); // @phpstan-ignore-line
        }

        return redirect()->route('filament.resources.questionnaires.upload-results', [$questionnaire, $result]);
    }
}
