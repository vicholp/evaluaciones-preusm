<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionnairePrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaires = QuestionnairePrototype::query();

        $whereSubjectId = $request->query('where_subject_id');

        if ($whereSubjectId) {
            $questionnaires = $questionnaires->where('subject_id', $whereSubjectId);
        }

        $questionnaires = $questionnaires->get();

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
     */
    public function store(Request $request): RedirectResponse
    {
        $prototype = QuestionnairePrototype::create([
            'subject_id' => $request->subject_id,
        ]);

        $prototype->versions()->create($request->all());

        return redirect()->route('teacher.question-bank.questionnaire-prototypes.show', $prototype);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionnairePrototype $questionnairePrototype): View
    {
        $itemsSorted = $questionnairePrototype->latest?->getSortedItems();

        if (Subject::isInScope($questionnairePrototype->subject, Subject::withStatementsQuestions())) {
            return view('teacher.question-bank.questionnaire.with-statement.show', [
                'questionnaire' => $questionnairePrototype,
                'itemsSorted' => $itemsSorted,
            ]);
        }

        return view('teacher.question-bank.questionnaire.show', [
            'questionnaire' => $questionnairePrototype,
            'questionsSorted' => $itemsSorted,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionnairePrototype $questionnairePrototype): View
    {
        return view('teacher.question-bank.questionnaire.edit', [
            'questionnaire' => $questionnairePrototype,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionnairePrototype $questionnairePrototype): RedirectResponse
    {
        $questionnairePrototype->versions()->create($request->all());

        return redirect()->route('teacher.question-bank.questionnaire-prototypes.show', $questionnairePrototype);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionnairePrototype $questionnairePrototype): void
    {
        //
    }

    public function editQuestions(QuestionnairePrototype $questionnairePrototype): View
    {
        if (Subject::isInScope($questionnairePrototype->subject, Subject::withStatementsQuestions())) {
            $items = $questionnairePrototype->latest?->getSortedItems();

            return view('teacher.question-bank.questionnaire.with-statement.edit-questions', [
                'questionnaire' => $questionnairePrototype,
                'items' => $items,
            ]);
        }
        $questions = $questionnairePrototype->latest?->questions ?? [];

        $questionsSorted = [];

        foreach ($questions as $question) {
            $questionsSorted[$question->pivot->position - 1] = $question->parent->load('latest');
        }

        return view('teacher.question-bank.questionnaire.edit-questions', [
            'questionnaire' => $questionnairePrototype,
            'questions' => $questionsSorted,
        ]);
    }

    public function updateQuestions(Request $request, QuestionnairePrototype $questionnairePrototype): RedirectResponse
    {
        $version = $questionnairePrototype->versions()->create($request->all());

        $questions = json_decode($request->questions);

        foreach ($questions as $index => $question) {
            $question = QuestionPrototype::find($question)->latest;
            $version->questions()->attach($question, ['position' => $index + 1]);
        }

        return redirect()->route('teacher.question-bank.questionnaire-prototypes.show', $questionnairePrototype);
    }
}
