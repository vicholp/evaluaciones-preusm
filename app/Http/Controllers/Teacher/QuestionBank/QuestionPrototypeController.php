<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.question-bank.question.index', [
            'questions' => QuestionPrototype::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.question-bank.question.create', [
            'subjects' => Subject::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionPrototype  $questionPrototype
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionPrototype $questionPrototype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionPrototype  $questionPrototype
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionPrototype $questionPrototype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionPrototype  $questionPrototype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionPrototype $questionPrototype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionPrototype  $questionPrototype
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionPrototype $questionPrototype)
    {
        //
    }
}
