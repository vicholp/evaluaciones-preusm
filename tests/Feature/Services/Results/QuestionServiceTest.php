<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
use App\Services\Results\QuestionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create alternatives', function () {
    $question = Question::factory()->create();

    $service = new QuestionService($question);

    $alternatives = $service->createAlternatives();

    expect($alternatives)->toHaveCount(6);
    expect($question->alternatives)->toHaveCount(6);
});

test('create from prototype', function () {
    $questionPrototype = QuestionPrototype::factory()->create();
    QuestionPrototypeVersion::factory()->hasTags(5)
        ->state(['question_prototype_id' => $questionPrototype->id])->count(2)->create();
    $questionnaire = Questionnaire::factory()->create();

    $question = QuestionService::createFromPrototype(
        $questionPrototype->latest->id,
        1,
        $questionnaire->id,
    );

    expect($question->alternatives)->toHaveCount(6);
    expect($question->questionnaire->id)->toBe($questionnaire->id);
    expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
    expect($question->alternatives()->whereCorrect(true)->first()->name)->toBe($questionPrototype->latest->answer);
    expect($question->tags->count())->toBe($questionPrototype->latest->tags->count());
});

test('mark as pilot', function () {
    $question = Question::factory()->state(['pilot' => false])->create();

    expect($question->pilot)->toBeFalse();

    $question->results()->markAsPilot();

    expect($question->pilot)->toBeTrue();
    expect($question->stats()->isUpdated())->toBeFalse();
});

test('unmark as pilot', function () {
    $question = Question::factory()->state(['pilot' => true])->create();

    expect($question->pilot)->toBeTrue();

    $question->results()->unmarkAsPilot();

    expect($question->pilot)->toBeFalse();
    expect($question->stats()->isUpdated())->toBeFalse();
});
