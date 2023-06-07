<?php

use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('has create', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire)->toBeInstanceOf(Questionnaire::class);
    expect($questionnaire->questions->count())->toBe(0);
    expect($questionnaire->students->count())->toBe(0);
});

test('has create with', function () {
    $questionnaire = Questionnaire::factory()->createWith();

    expect($questionnaire)->toBeInstanceOf(Questionnaire::class);
    expect($questionnaire->questions->count())->toBe(15);
    expect($questionnaire->students->count())->toBe(5);
});

test('has create with many', function () {
    $questionnaires = Questionnaire::factory()->count(3)->createWith();

    expect($questionnaires->count())->toBe(3);

    foreach ($questionnaires as $questionnaire) {
        expect($questionnaire)->toBeInstanceOf(Questionnaire::class);
        expect($questionnaire->questions->count())->toBe(15);
        expect($questionnaire->students->count())->toBe(5);
    }
});
