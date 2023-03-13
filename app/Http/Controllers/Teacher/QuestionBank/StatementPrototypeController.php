<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\StatementPrototype;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatementPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $statements = StatementPrototype::all();

        return view('teacher.question-bank.statement.index', [
            'statements' => $statements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $subjects = Subject::withStatementsQuestions()->get();

        return view('teacher.question-bank.statement.create', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $statement = StatementPrototype::create($request->all());

        return redirect()->route('teacher.question-bank.statement-prototypes.show', $statement);
    }

    /**
     * Display the specified resource.
     */
    public function show(StatementPrototype $statementPrototype): View
    {
        return view('teacher.question-bank.statement.show', [
            'statement' => $statementPrototype,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatementPrototype $statementPrototype): View
    {
        return view('teacher.question-bank.statement.edit', [
            'statement' => $statementPrototype,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatementPrototype $statementPrototype): RedirectResponse
    {
        $statementPrototype->update($request->all());

        return redirect()->route('teacher.question-bank.statement-prototypes.show', $statementPrototype);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatementPrototype $statementPrototype): void
    {
        //
    }
}
