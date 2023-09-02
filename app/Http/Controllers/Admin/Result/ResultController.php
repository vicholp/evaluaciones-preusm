<?php

namespace App\Http\Controllers\Admin\Result;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadQuestionnaireResultsRequest;
use App\Imports\Sheets\AnswersImport;
use App\Imports\Sheets\FormScannerImport;
use App\Imports\Sheets\TagQuestionsImport;
use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(): View
    {
        $results = QuestionnaireImportAnswersResult::orderBy('created_at', 'desc')
            ->where('root_questionnaire_import_answers_result_id', null)->get();

        return view('admin.results.index', [
            'results' => $results,
        ]);
    }

    public function upload(): View
    {
        $questionnaires = Questionnaire::all();

        return view('admin.results.upload', [
            'questionnaires' => $questionnaires,
        ]);
    }

    public function import(UploadQuestionnaireResultsRequest $request): RedirectResponse
    {
        $questionnaire = Questionnaire::whereId($request->questionnaire_id)->firstOrFail();

        $shouldImportFormScanner = $request->file('file_formscanner') !== null;
        $shouldImportMoodleGrades = $request->file('file_grades') !== null;
        $shouldImportMoodleAnswers = $request->file('file_answers') !== null;
        $shouldImportTags = $request->file('file_tags') !== null;

        $shouldImport = $shouldImportFormScanner || $shouldImportMoodleGrades || $shouldImportMoodleAnswers || $shouldImportTags;

        if (!$shouldImport) {
            return redirect()->back()
                ->withErrors('No hay archivos para importar');
        }

        $result = QuestionnaireImportAnswersResult::create([
            'questionnaire_id' => $questionnaire->id,
            'data' => [],
            'log' => [],
        ]);

        if ($questionnaire->questions->count() === 0) {
            $result->insertIntoLog('Question count is 0, aborting');

            return redirect()->back()
                ->withErrors('El ensayo es invalido, no tiene preguntas');
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

        return redirect()->route('admin.results.show', $result);
    }

    public function show(QuestionnaireImportAnswersResult $questionnaireImportAnswersResult): View
    {
        return view('admin.results.show', [
            'results' => $questionnaireImportAnswersResult,
        ]);
    }
}
