<?php

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create one with alternatives', function () {
    $questionnaire = Questionnaire::factory()->create();
    $question = Question::factory()->for($questionnaire)->createWithAlternatives();

    expect($question->id)->toBe($questionnaire->questions->first()->id);
});

test('create many with alternatives', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(10)->createWithAlternatives();

    expect($questions->pluck('id'))->toEqualCanonicalizing($questionnaire->questions->pluck('id'));
    expect($questions->count())->toBe(10);
});
