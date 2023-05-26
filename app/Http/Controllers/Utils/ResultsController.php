<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultsController extends Controller
{
    public function index(): View
    {
        return view('utils.results.index');
    }

    public function start(): View
    {
        $subjects = Subject::forQuestions()->get();
        $questionnaireGroups = QuestionnaireGroup::get();

        return view('utils.results.start', [
            'subjects' => $subjects,
            'questionnaireGroups' => $questionnaireGroups,
        ]);
    }

    public function storeQuestionnaire(Request $request): RedirectResponse
    {
        $prototype = QuestionnairePrototype::create([
            'subject_id' => $request->subject_id,
        ]);

        $version = $prototype->versions()->create();

        $questionnaire = Questionnaire::create([
            'subject_id' => $request->subject_id,
            'questionnaire_group_id' => $request->questionnaire_group_id,
            'questionnaire_prototype_version_id' => $version->id,
        ]);

        return redirect()->route('utils.results.upload-question', $questionnaire);
    }

    public function uploadQuestion(Questionnaire $questionnaire): View
    {
        return view('utils.results.upload-question', [
            'questionnaire' => $questionnaire,
            'position' => $questionnaire->questions()->count() + 1,
        ]);
    }

    public function storeQuestion(Questionnaire $questionnaire, Request $request): RedirectResponse
    {
        $position = $questionnaire->questions()->count() + 1;

        $prototype = $questionnaire->prototype;

        $question = QuestionPrototype::create([
            'subject_id' => $questionnaire->subject_id,
        ]);

        $latest = $question->versions()->create([
            'body' => $request->body,
            'answer' => $request->answer,
        ]);

        $prototype->questions()->attach($latest, [ // @phpstan-ignore-line
            'position' => $position,
        ]);

        $questionnaire->questions()->create([
            'position' => $position,
            'question_prototype_version_id' => $latest->id,
        ]);

        return redirect()->route('utils.results.upload-question', $questionnaire);
    }
}
