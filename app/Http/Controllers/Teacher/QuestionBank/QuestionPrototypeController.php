<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use App\Models\StatementPrototype;
use App\Models\Subject;
use App\Models\TagGroup;
use App\Services\QuestionBank\ReviewService;
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

        $showCreateStatement = false;

        if ($whereSubjectId) {
            $whereSubject = Subject::findOrFail($whereSubjectId);

            $questions = $questions->where('subject_id', $whereSubjectId);

            $showCreateStatement = Subject::isInScope($whereSubject, Subject::withStatementsQuestions());
        }

        $questions = $questions->get();

        return view('teacher.question-bank.question.index', [
            'questions' => $questions->load('latest'),
            'showCreateStatement' => $showCreateStatement,
            'whereSubject' => $whereSubject ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tags = TagGroup::with('tags')->get();
        $statements = StatementPrototype::get();
        $tagGroups = TagGroup::get();

        $subject = Subject::find(request()->query('where_subject_id'));

        $tags = [];

        foreach ($tagGroups as $tagGroup) {
            $tags[$tagGroup->id] = $tagGroup->tags()
                ->where('active', true)
                ->where(function ($query) use ($subject) {
                    if (!$subject) {
                        return;
                    }

                    $query->whereIn('subject_id', $subject->parents()->pluck('id'))
                        ->orWhere('subject_id', $subject->id)
                        ->orWhere('subject_id', null);
                })
                ->get();
        }

        return view('teacher.question-bank.question.create', [
            'subjects' => Subject::all(),
            'statements' => $statements,
            'tags' => $tags,
            'tagGroups' => $tagGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $prototype = QuestionPrototype::create([
            'subject_id' => $request->subject_id,
            'statement_prototype_id' => $request->statement_prototype_id,
        ]);

        $version = $prototype->versions()->create($request->all());

        foreach ($request->tags as $tags) {
            $tags = json_decode($tags);
            $version->tags()->attach($tags);
        }

        return redirect()->route('teacher.question-bank.question-prototypes.show', [
            $prototype,
            'where_subject_id' => $prototype->subject_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionPrototype $questionPrototype): View
    {
        return view('teacher.question-bank.question.show', [
            'question' => $questionPrototype,
            'reviewService' => new ReviewService($questionPrototype->latest), // @phpstan-ignore-line
            'user' => \Auth::user(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionPrototype $questionPrototype): View
    {
        $tagGroups = TagGroup::get();
        $tags = [];
        $selectedTags = [];

        $subject = $questionPrototype->subject;

        foreach ($tagGroups as $tagGroup) {
            $selectedTags[$tagGroup->name] = [];
        }

        foreach ($questionPrototype->latest?->tags as $tag) { // @phpstan-ignore-line
            array_push($selectedTags[$tag->tagGroup?->name], $tag);
        }

        foreach ($tagGroups as $tagGroup) {
            $tags[$tagGroup->id] = $tagGroup->tags()
                ->where('active', true)
                ->where(function ($query) use ($subject) {
                    $query->whereIn('subject_id', $subject->parents()->pluck('id'))
                        ->orWhere('subject_id', $subject->id)
                        ->orWhere('subject_id', null);
                })
                ->get();
        }

        return view('teacher.question-bank.question.edit', [
            'question' => $questionPrototype,
            'selectedTags' => $selectedTags,
            'tags' => $tags,
            'tagGroups' => $tagGroups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionPrototype $questionPrototype): RedirectResponse
    {
        $version = $questionPrototype->latest;

        if ($version?->body !== $request->body || $version?->answer !== $request->answer) { // @phpstan-ignore-line
            $version = $questionPrototype->versions()->create($request->all());
        } else {
            $version->update($request->all());
        }

        $version->tags()->detach();

        foreach ($request->tags as $tags) {
            $tags = json_decode($tags);
            $version->tags()->attach($tags);
        }

        return redirect()->route('teacher.question-bank.question-prototypes.show', [
            $questionPrototype,
            'where_subject_id' => $questionPrototype->subject_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionPrototype $questionPrototype): void
    {
        //
    }

    public function review(QuestionPrototype $questionPrototype): RedirectResponse
    {
        $user = \Auth::user();

        (new ReviewService($questionPrototype->latest))->reviewAction($user); // @phpstan-ignore-line

        return redirect()->back();
    }
}
