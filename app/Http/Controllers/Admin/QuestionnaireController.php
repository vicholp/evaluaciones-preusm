<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Http\Requests\UploadQuestionnaireResultsRequest;
use App\Imports\QuestionnaireImport;
use App\Imports\Sheets\AnswersImport;
use App\Imports\Sheets\GradesImport;
use App\Imports\Sheets\TagQuestionsImport;
use App\Jobs\ComputeAllStatsJob;
use App\Jobs\Stats\ComputeQuestionnaireStatsJob;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires = Questionnaire::get();

        return view('admin.questionnaires.index', ['questionnaires' => $questionnaires]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionnaireGroups = QuestionnaireGroup::get();
        $subjects = Subject::get();

        return view('admin.questionnaires.edit', [
            'questionnaireGroups' => $questionnaireGroups,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionnaireRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionnaireRequest $request)
    {
        $questionnaire = Questionnaire::create($request->validated());
        $questionnaire->save();

        return redirect()->route('admin.questionnaires.show', $questionnaire);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function show(Questionnaire $questionnaire)
    {
        return view('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Questionnaire $questionnaire)
    {
        $questionnaireGroups = QuestionnaireGroup::get();
        $subjects = Subject::get();

        return view('admin.questionnaires.edit', [
            'questionnaire' => $questionnaire,
            'questionnaireGroups' => $questionnaireGroups,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionnaireRequest  $request
     * @param  \App\Models\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionnaireRequest $request, Questionnaire $questionnaire)
    {
        $questionnaire->fill($request->validated());
        $questionnaire->save();

        return redirect()->route('admin.questionnaires.show', $questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Questionnaire $questionnaire)
    {
        $questionnaire->delete();

        return redirect()->route('admin.questionnaires.index');
    }

    public function computeStatsQuestionnaires()
    {
        Cache::flush();

        ComputeAllStatsJob::dispatch();

        return redirect()->route('admin.questionnaires.index');
    }

    public function computeStatsQuestionnaire(Questionnaire $questionnaire)
    {
        ComputeQuestionnaireStatsJob::dispatch($questionnaire);

        return redirect()->route('admin.questionnaires.show', $questionnaire);
    }

    public function uploadResults(Questionnaire $questionnaire)
    {
        return view('admin.questionnaires.upload-results', ['questionnaire' => $questionnaire]);
    }

    public function importResults(UploadQuestionnaireResultsRequest $request, Questionnaire $questionnaire)
    {
        if($request->file('file_answers')){
            Excel::import(new QuestionnaireImport($questionnaire->id, true), $request->file('file_stats'));
            Excel::import(new AnswersImport($questionnaire->id), $request->file('file_answers'));
        } else if($request->file('file_grades')){
            Excel::import(new QuestionnaireImport($questionnaire->id, false), $request->file('file_stats'));
            Excel::import(new GradesImport($questionnaire->id), $request->file('file_grades'));
        } else {
            return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
        }

        Excel::import(new TagQuestionsImport($questionnaire->id), $request->file('file_tags'));

        return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }
}
