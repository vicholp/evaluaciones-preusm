<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Http\Requests\UploadQuestionnaireResultsRequest;
use App\Imports\QuestionnaireImport;
use App\Imports\Sheets\AnswersImport;
use App\Imports\Sheets\FormScannerImport;
use App\Imports\Sheets\GradesImport;
use App\Imports\Sheets\TagQuestionsImport;
use App\Jobs\ComputeAllStatsJob;
use App\Jobs\Stats\ComputeQuestionnaireStatsJob;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class QuestionnaireController extends Controller
{
    public function uploadResults(Questionnaire $questionnaire)
    {
        return view('admin.questionnaires.upload-results', ['questionnaire' => $questionnaire]);
    }

    public function importResults(UploadQuestionnaireResultsRequest $request, Questionnaire $questionnaire)
    {
        if (!$request->file('file_answers') && !$request->file('file_grades') && !$request->file('file_formscanner')){
            return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
        }

        if($request->file('file_grades') && $request->file('file_formscanner')){
            return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
        }

        if ($request->file('file_grades')) {
            Excel::import(new QuestionnaireImport($questionnaire->id, false), $request->file('file_stats')); // @phpstan-ignore-line
            Excel::import(new GradesImport($questionnaire->id), $request->file('file_grades')); // @phpstan-ignore-line
        } else {
            Excel::import(new QuestionnaireImport($questionnaire->id, true), $request->file('file_stats')); // @phpstan-ignore-line
            if ($request->file('file_answers')) {
                Excel::import(new AnswersImport($questionnaire->id), $request->file('file_answers')); // @phpstan-ignore-line
            }
            if ($request->file('file_formscanner')) {
                Excel::import(new FormScannerImport($questionnaire->id), $request->file('file_formscanner'));// @phpstan-ignore-line
            }
        }

        Excel::import(new TagQuestionsImport($questionnaire->id), $request->file('file_tags')); // @phpstan-ignore-line

        // return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }
}
