<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\StatementPrototype;
use Illuminate\Http\Request;

class StatementPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\StatementPrototype  $statementPrototype
     * @return \Illuminate\Http\Response
     */
    public function show(StatementPrototype $statementPrototype)
    {
        return view('teacher.question-bank.statement.show', [
            'statement' => $statementPrototype,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatementPrototype  $statementPrototype
     * @return \Illuminate\Http\Response
     */
    public function edit(StatementPrototype $statementPrototype)
    {
        return view('teacher.question-bank.statement.edit', [
            'statement' => $statementPrototype,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StatementPrototype  $statementPrototype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatementPrototype $statementPrototype)
    {
        $statementPrototype->update($request->all());

        return redirect()->route('teacher.question-bank.statement-prototypes.show', $statementPrototype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatementPrototype  $statementPrototype
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatementPrototype $statementPrototype)
    {
        //
    }
}
