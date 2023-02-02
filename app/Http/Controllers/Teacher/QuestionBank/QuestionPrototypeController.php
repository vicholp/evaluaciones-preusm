<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $subjectId = $request->query('subject_id', null);

        if ($subjectId) {
            $questions = QuestionPrototype::where('subject_id', $subjectId)->get();
        } else {
            $questions = QuestionPrototype::get();
        }

        return view('teacher.question-bank.question.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tags = TagGroup::with('tags')->get();

        return view('teacher.question-bank.question.create', [
            'subjects' => Subject::all(),
            'tags' => $tags,
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

        $prototype->versions()->create($request->all());

        return redirect()->route('teacher.question-bank.question-prototypes.show', $prototype);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionPrototype $questionPrototype): View
    {
        return view('teacher.question-bank.question.show', [
            'question' => $questionPrototype,
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
     */
    public function update(Request $request, QuestionPrototype $questionPrototype): RedirectResponse
    {
        $questionPrototype->versions()->create($request->all());

        return redirect()->route('teacher.question-bank.question-prototypes.show', $questionPrototype);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionPrototype $questionPrototype): void
    {
        //
    }
}
