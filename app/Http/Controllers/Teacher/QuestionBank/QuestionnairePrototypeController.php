<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnairePrototypeRequest;
use App\Http\Requests\UpdateQuestionnairePrototypeRequest;
use App\Models\QuestionnairePrototype;
use Illuminate\Http\Request;

class QuestionnairePrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjectId = $request->query('subject_id', '*');
        $questionnaires = QuestionnairePrototype::where('subject_id', $subjectId)->get();

        return view('teacher.question-bank.questionnaire.index', [
            'questionnaires' => $questionnaires,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionnairePrototypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionnairePrototypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionnairePrototypeRequest  $request
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionnairePrototypeRequest $request, QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }
}
