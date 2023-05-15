<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManualUploadController extends Controller
{
    public function start(\Request $request): View
    {
        $subjects = Subject::all();

        return view('teacher.question-bank.manual-upload.start', [
            'subjects' => $subjects,
        ]);
    }

    public function storeQuestionnaire(Request $request): RedirectResponse
    {
        $prototype = QuestionnairePrototype::create([
            'subject_id' => $request->subject_id,
        ]);

        $prototype->versions()->create();

        return redirect()->route('teacher.question-bank.manual-upload.create-question', $prototype);
    }

    public function createQuestion(QuestionnairePrototype $questionnairePrototype): View
    {
        return view('teacher.question-bank.manual-upload.create-question', [
            'questionnairePrototype' => $questionnairePrototype,
            'latest' => $questionnairePrototype->latest,
        ]);
    }

    public function storeQuestion(QuestionnairePrototype $questionnairePrototype, Request $request): RedirectResponse
    {
        $questionnaire = $questionnairePrototype->latest;

        $position = $questionnaire?->questions()->count() + 1;

        $question = QuestionPrototype::create([
            'subject_id' => $questionnairePrototype->subject_id,
        ]);

        $latest = $question->versions()->create([
            'body' => $request->body,
            'answer' => $request->answer,
        ]);

        $questionnaire?->questions()->attach($latest, [
            'position' => $position,
        ]);

        return redirect()->route('teacher.question-bank.manual-upload.create-question', $questionnairePrototype);
    }

    public function review(QuestionnairePrototype $questionnairePrototype): View
    {
        return view('teacher.question-bank.manual-upload.review', [
            'questionnairePrototype' => $questionnairePrototype,
            'latest' => $questionnairePrototype->latest,
        ]);
    }
}
