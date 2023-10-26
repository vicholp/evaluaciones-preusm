<?php

use App\Services\QuestionBank\RevisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CreateQuestionnairePrototypeFullHelper;

uses(RefreshDatabase::class);

it('start revision', function () {
    $questionnaire = CreateQuestionnairePrototypeFullHelper::call();

    $service = new RevisionService($questionnaire);

    $revision = $service->startRevision();

    expect($revision['questionnairePrototypeVersion']->id)->toBe($questionnaire->latest->id);
});

it('question revision', function () {
    $questionnaire = CreateQuestionnairePrototypeFullHelper::call();

    $questions = $questionnaire->latest->questions()->get();

    $service = new RevisionService($questionnaire);

    $revision = $service->questionRevision(1);

    expect($revision['currentQuestion']->id)->toBe($questions[0]->id);
});
