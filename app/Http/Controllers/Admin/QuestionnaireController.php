<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionnaireFromPrototypeRequest;
use App\Http\Requests\Admin\StoreQuestionnaireRequest;
use App\Http\Requests\Admin\UpdateQuestionnaireRequest;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use App\Services\Results\QuestionnaireService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(): View
    {
        return view('admin.questionnaires.index', [
            'questionnaires' => Questionnaire::withCount('questions')->get(),
        ]);
    }

    public function create(): View
    {
        $subject = Subject::forQuestionnaires()->get();
        $questionnaireGroups = QuestionnaireGroup::all();

        return view('admin.questionnaires.create', [
            'subjects' => $subject,
            'questionnaireGroups' => $questionnaireGroups,
        ]);
    }

    public function createFromPrototype(): View
    {
        $questionairePrototypes = QuestionnairePrototype::get()->sortByDesc('subject.name');
        $questionnaireGroups = QuestionnaireGroup::all();

        return view('admin.questionnaires.create-from-prototype', [
            'questionnairePrototypes' => $questionairePrototypes,
            'questionnaireGroups' => $questionnaireGroups,
        ]);
    }

    public function store(StoreQuestionnaireRequest $request): RedirectResponse
    {
        $questionnaire = QuestionnaireService::create(
            $request->name,
            $request->questionnaire_group_id,
            $request->subject_id,
            $request->questions_count,
        );

        return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }

    public function edit(Questionnaire $questionnaire): View
    {
        $subjects = Subject::forQuestionnaires()->get();
        $questionnaireGroups = QuestionnaireGroup::all();

        return view('admin.questionnaires.edit', [
            'questionnaire' => $questionnaire,
            'subjects' => $subjects,
            'questionnaireGroups' => $questionnaireGroups,
        ]);
    }

    public function update(
        UpdateQuestionnaireRequest $request,
        Questionnaire $questionnaire
    ): RedirectResponse {
        $questionnaire->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }

    public function show(Questionnaire $questionnaire): View
    {
        return view('admin.questionnaires.show', [
            'questionnaire' => $questionnaire,
        ]);
    }

    public static function storeFromPrototype(
        StoreQuestionnaireFromPrototypeRequest $request
    ): RedirectResponse {
        $questionnaire = QuestionnaireService::createFromPrototype(
            $request->name,
            QuestionnaireGroup::findOrFail($request->questionnaire_group_id), // @phpstan-ignore-line
            QuestionnairePrototype::findOrFail($request->questionnaire_prototype_id)->latest, // @phpstan-ignore-line
        );

        return redirect()->route('admin.questionnaires.show', ['questionnaire' => $questionnaire]);
    }

    public function destroy(Questionnaire $questionnaire): RedirectResponse
    {
        $questionnaire->delete();

        return redirect()->route('admin.questionnaires.index');
    }
}
