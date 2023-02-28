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
        if (Subject::isInScope($questionnairePrototype->subject, Subject::withStatementsQuestions())) {
            $itemsSorted = [];
            $questions = $questionnairePrototype->latest?->questions ?? [];
            $statements = $questionnairePrototype->latest?->statements ?? [];

            foreach ($questions as $question) {
                $itemsSorted[$question->pivot->position - 1] = [
                    'type' => 'question',
                    'item' => $question,
                    'index' => $question->pivot->position,
                ];
            }

            foreach ($statements as $statement) {
                $itemsSorted[$statement->pivot->position - 1] = [
                    'type' => 'statement',
                    'item' => $statement,
                ];
            }

            ksort($itemsSorted);

            $statements = 0;

            foreach ($itemsSorted as $index => $item) {
                if ($item['type'] === 'statement') {
                    $statements++;
                    continue;
                }

                $itemsSorted[$index]['index'] -= $statements;
            }

            return view('teacher.question-bank.questionnaire.show-with-statements', [
                'questionnaire' => $questionnairePrototype,
                'itemsSorted' => $itemsSorted,
            ]);
        }
        $questions = $questionnairePrototype->latest?->questions ?? [];

        $questionsSorted = [];

        foreach ($questions as $question) {
            $questionsSorted[$question->pivot->position - 1] = $question;
        }

        ksort($questionsSorted);

        return view('teacher.question-bank.questionnaire.show', [
            'questionnaire' => $questionnairePrototype,
            'questionsSorted' => $questionsSorted,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionnairePrototype $questionnairePrototype): View
    {
        $questions = $questionnairePrototype->latest?->questions ?? [];

        $questionsSorted = [];

        foreach ($questions as $question) {
            $questionsSorted[$question->pivot->position - 1] = $question->parent->load('latest');
        }

        return view('teacher.question-bank.questionnaire.edit', [
            'questionnaire' => $questionnairePrototype,
            'questions' => $questionsSorted,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionnairePrototype $questionnairePrototype): RedirectResponse
    {
        $version = $questionnairePrototype->versions()->create($request->all());

        $questions = json_decode($request->questions);

        foreach ($questions as $index => $question) {
            $question = QuestionPrototype::find($question)->latest;
            $version->questions()->attach($question, ['position' => $index + 1]);
        }

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
            $statements = $questionnairePrototype->latest?->statements ?? [];

            return view('teacher.question-bank.questionnaire.edit-statements', [
                'questionnaire' => $questionnairePrototype,
            ]);
        }
        $questions = $questionnairePrototype->latest?->questions ?? [];

        $questionsSorted = [];

        foreach ($questions as $question) {
            $questionsSorted[$question->pivot->position - 1] = $question->parent->load('latest');
        }

        return view('teacher.question-bank.questionnaire.edit', [
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
