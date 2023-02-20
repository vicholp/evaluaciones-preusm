<?php

use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create one with questions', function () {
    $questionnaire = Questionnaire::factory()->createWithQuestions();

    expect($questionnaire->questions->count())->toBe(60);
    expect($questionnaire->questions[0]->alternatives->count())->toBeGreaterThanOrEqual(4);
});

test('create many with questions', function () {
    $questionnaires = Questionnaire::factory()->createWithQuestions();

    expect($questionnaires->pluck('id'))->toEqualCanonicalizing(Questionnaire::get()->pluck('id'));
});
