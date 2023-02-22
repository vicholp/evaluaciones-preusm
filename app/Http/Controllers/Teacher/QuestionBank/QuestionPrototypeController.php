<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use App\Models\Subject;
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
        $questions = QuestionPrototype::query();

        $whereSubjectId = $request->query('where_subject_id');

        if ($whereSubjectId) {
            $questions = $questions->where('subject_id', $whereSubjectId);
        }

        $questions = $questions->get();

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

        $version = $prototype->versions()->create($request->all());

        foreach ($request->tags as $tags) {
            $tags = json_decode($tags);
            $version->tags()->attach($tags);
        }

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
        $tags = TagGroup::with('tags')->get();
        $selectedTags = [];

        foreach ($tags as $tagGroup) {
            $selectedTags[$tagGroup->name] = [];
        }

        foreach ($questionPrototype->latest->tags as $tag) {
            array_push($selectedTags[$tag->tagGroup->name], $tag);
        }

        return view('teacher.question-bank.question.edit', [
            'question' => $questionPrototype,
            'selectedTags' => $selectedTags,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionPrototype $questionPrototype): RedirectResponse
    {
        $version = $questionPrototype->versions()->create($request->all());

        foreach ($request->tags as $tags) {
            $tags = json_decode($tags);
            $version->tags()->attach($tags);
        }

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
