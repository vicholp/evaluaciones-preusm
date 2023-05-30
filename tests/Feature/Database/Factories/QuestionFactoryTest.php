<?php

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create one with alternatives', function () {
    $questionnaire = Questionnaire::factory()->create();
    $question = Question::factory()->for($questionnaire)->createWithAlternatives();

    expect($question->id)->toBe($questionnaire->questions()->first()->id);
    expect($questionnaire->questions()->count())->toBe(1);
    expect($question->alternatives()->count())->toBe(6);
    expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
    expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
});

test('create many with alternatives', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(10)->createWithAlternatives();

    expect($questions->pluck('id'))->toEqualCanonicalizing($questionnaire->questions()->get()->pluck('id'));
    expect($questions->count())->toBe(10);
    expect($questionnaire->questions()->count())->toBe(10);
    foreach($questions as $question) {
        expect($question->alternatives()->count())->toBe(6);
        expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
        expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
    }
});
