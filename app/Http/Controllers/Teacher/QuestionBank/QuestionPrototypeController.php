<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teacher.question-bank.question.index', [
            'questions' => QuestionPrototype::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('teacher.question-bank.question.create', [
            'subjects' => Subject::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $prototype = QuestionPrototype::create([
            'subject_id' => $request->subject_id,
        ]);

        $prototype->versions()->create(
            [

            ...$request->all(),
            'answer' => 'A',
            ]
        );

        return redirect()->route('teacher.question-bank.question-prototypes.show', $prototype);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionPrototype $questionPrototype): View
    {
        return view('teacher.question-bank.question.show', [
            'question' =>  $questionPrototype,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionPrototype $questionPrototype): View
    {
        return view('teacher.question-bank.question.edit', [
                'question' => $questionPrototype,
        ]);
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
        dd($request);
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
