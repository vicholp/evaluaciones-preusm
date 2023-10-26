<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\QuestionBank\ManualUpload\StoreQuestionnaireRequest;
use App\Http\Requests\Teacher\QuestionBank\ManualUpload\StoreQuestionRequest;
use App\Http\Requests\Teacher\QuestionBank\ManualUpload\StoreStatementRequest;
use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use App\Models\TagGroup;
use App\Services\QuestionBank\ManualUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManualUploadController extends Controller
{
    public function start(): View
    {
        $subjects = Subject::all();

        return view('teacher.question-bank.manual-upload.start', [
            'subjects' => $subjects,
        ]);
    }

    public function storeQuestionnaire(StoreQuestionnaireRequest $request): RedirectResponse
    {
        $questionnaire = ManualUploadService::createQuestionnaire(
            $request->name,
            $request->description,
            Subject::whereId($request->subject_id)->firstOrFail()
        );

        if (Subject::isInScope($questionnaire->subject, Subject::withStatementsQuestions())) {
            return redirect()->route('teacher.question-bank.manual-upload.create-statement', $questionnaire);
        } else {
            return redirect()->route('teacher.question-bank.manual-upload.create-question', $questionnaire);
        }
    }

    public function createStatement(QuestionnairePrototype $questionnairePrototype): View
    {
        return view('teacher.question-bank.manual-upload.create-statement', [
            'questionnairePrototype' => $questionnairePrototype,
            'latest' => $questionnairePrototype->latest,
            'itemsSorted' => $questionnairePrototype->latest->getSortedItems(),
        ]);
    }

    public function createQuestion(QuestionnairePrototype $questionnairePrototype): View
    {
        $subject = $questionnairePrototype->subject;
        $tags = [];
        $tagGroups = TagGroup::get();

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

        return view('teacher.question-bank.manual-upload.create-question', [
            'questionnairePrototype' => $questionnairePrototype,
            'latest' => $questionnairePrototype->latest,
            'itemsSorted' => $questionnairePrototype->latest->getSortedItems(),
            'tags' => $tags,
            'tagGroups' => $tagGroups,
        ]);
    }

    public function storeStatement(
        QuestionnairePrototype $questionnairePrototype,
        StoreStatementRequest $request,
    ): RedirectResponse {
        ManualUploadService::createStatement(
            $questionnairePrototype,
            $request->body,
            $request->name,
            $request->description,
        );

        return redirect()->route('teacher.question-bank.manual-upload.create-question', $questionnairePrototype);
    }

    public function storeQuestion(
        QuestionnairePrototype $questionnairePrototype,
        StoreQuestionRequest $request
    ): RedirectResponse {
        ManualUploadService::createQuestion(
            $questionnairePrototype,
            $request->name,
            $request->description,
            $request->body,
            $request->answer,
            $request->solution,
            $request->tags
        );

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
