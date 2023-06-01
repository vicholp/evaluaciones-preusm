<?php

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('has create', function () {
    $question = Question::factory()->create();

    expect($question)->toBeInstanceOf(Question::class);
    expect($question->alternatives->count())->toBe(0);
    expect($question->students->count())->toBe(0);
});

test('has create with', function () {
    $question = Question::factory()->createWith();

    expect($question)->toBeInstanceOf(Question::class);
    expect($question->alternatives->count())->toBe(6);
    expect($question->students->count())->toBe(0);
});

test('has create with many', function () {
    $questions = Question::factory()->count(3)->createWith();

    expect($questions->count())->toBe(3);

    foreach ($questions as $question) {
        expect($question)->toBeInstanceOf(Question::class);
        expect($question->alternatives->count())->toBe(6);
        expect($question->students->count())->toBe(0);
    }
});
