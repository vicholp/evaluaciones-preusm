<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionnairePrototypeRequest;
use App\Http\Requests\UpdateQuestionnairePrototypeRequest;
use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionnairePrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $subjectId = $request->query('subject_id', '*');
        $questionnaires = QuestionnairePrototype::where('subject_id', $subjectId)->get();

        return view('teacher.question-bank.questionnaire.index', [
            'questionnaires' => $questionnaires,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $subjects = Subject::all();

        return view('teacher.question-bank.questionnaire.create', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionnairePrototypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionnairePrototypeRequest $request, QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }
}
