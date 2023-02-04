<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQuestionnairePrototypeRequest;
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

        $version = $prototype->versions()->create($request->all());

        $questions = json_decode($request->questions);

        $questions = QuestionPrototype::findMany($questions)->map(fn ($question) => $question->latest);

        foreach ($questions as $index => $question) {
            $version->questions()->attach($question, ['position' => $index + 1]);
        }


        return redirect()->route('teacher.question-bank.questionnaire-prototypes.show', $prototype);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionnairePrototype $questionnairePrototype): View
    {
        return view('teacher.question-bank.questionnaire.show', [
            'questionnaire' => $questionnairePrototype,
        ]);
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
