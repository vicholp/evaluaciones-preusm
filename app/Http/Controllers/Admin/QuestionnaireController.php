<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Subject;

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
}
