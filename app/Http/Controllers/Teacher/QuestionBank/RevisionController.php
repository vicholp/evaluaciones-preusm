<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototypeVersion;
use App\Models\TagGroup;
use App\Services\QuestionBank\QuestionPrototypeService;
use App\Services\QuestionBank\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RevisionController extends Controller
{
    public function questionnaire(QuestionnairePrototypeVersion $questionnairePrototypeVersion): View
    {
        $firstQuestion = $questionnairePrototypeVersion->questions()->orderByPivot('position')->first();

        return view('teacher.question-bank.revision.questionnaire', [
            'questionnaire' => $questionnairePrototypeVersion,
            'firstQuestion' => $firstQuestion,
        ]);
    }

    public function question(
        QuestionnairePrototypeVersion $questionnairePrototypeVersion,
        QuestionPrototypeVersion $questionPrototypeVersion
    ): View {
        $questionnaire = $questionnairePrototypeVersion;
        $subject = $questionnaire->parent->subject;
        $tags = (new QuestionPrototypeService())->getAttachableTagsForSubject($subject);

        $pivot = $questionnairePrototypeVersion->questions() // @phpstan-ignore-line
            ->where('question_prototype_versions.id', $questionPrototypeVersion->id)
            ->first()->pivot;

        $nextQuestion = $questionnairePrototypeVersion->questions()
            ->wherePivot('position', '>', $pivot->position)
            ->orderByPivot('position')->first();

        $previusQuestion = $questionnairePrototypeVersion->questions()
            ->wherePivot('position', '<', $pivot->position)
            ->orderByPivot('position', 'desc')->first();

        $tagGroups = TagGroup::with('tags')->get();

        $selectedTags = [];

        foreach ($tagGroups as $tagGroup) {
            $selectedTags[$tagGroup->name] = [];
        }

        foreach ($questionPrototypeVersion->tags as $tag) {
            array_push($selectedTags[$tag->tagGroup->name], $tag); // @phpstan-ignore-line
        }

        return view('teacher.question-bank.revision.question', [
            'question' => $questionPrototypeVersion,
            'nextQuestion' => $nextQuestion,
            'previusQuestion' => $previusQuestion,
            'tags' => $tags,
            'tagGroups' => $tagGroups,
            'selectedTags' => $selectedTags,
            'questionnaire' => $questionnaire,
            'position' => $pivot->position,
            'totalQuestions' => $questionnairePrototypeVersion->questions()->count(),
            'reviewService' => new ReviewService($questionPrototypeVersion),
            'user' => Auth::user(),
        ]);
    }

    public function updateQuestion(
        Request $request,
        QuestionnairePrototypeVersion $questionnairePrototypeVersion,
        QuestionPrototypeVersion $questionPrototypeVersion
    ): RedirectResponse {
        $oldVersion = $questionnairePrototypeVersion;

        $newVersion = $questionnairePrototypeVersion->parent->versions()->create([
            'name' => $questionnairePrototypeVersion->name,
            'description' => $questionnairePrototypeVersion->description,
        ]);

        $questionNewVersion = $questionPrototypeVersion->parent->versions()->create($request->all());

        foreach ($oldVersion->questions as $question) {
            $newVersion->questions()->attach($question, [
                'position' => $question->pivot->position, // @phpstan-ignore-line
            ]);
        }

        $newVersion->questions()->updateExistingPivot($questionPrototypeVersion, [
            'question_prototype_version_id' => $questionNewVersion->id,
        ]);

        return redirect()->route('teacher.question-bank.revision.question', [
            $newVersion,
            $questionNewVersion,
        ]);
    }

    public function review(
        QuestionnairePrototypeVersion $questionnairePrototypeVersion,
        QuestionPrototypeVersion $questionPrototypeVersion
    ): RedirectResponse {
        $user = Auth::user();

        (new ReviewService($questionPrototypeVersion))->reviewAction($user); // @phpstan-ignore-line

        return redirect()->route('teacher.question-bank.revision.question', [
            $questionnairePrototypeVersion,
            $questionPrototypeVersion,
        ]);
    }
}
