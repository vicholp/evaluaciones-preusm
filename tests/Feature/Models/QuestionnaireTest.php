<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Services\Grading\GradingService;
use App\Services\Stats\QuestionnaireStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Expectations\ModelExpectation;

uses(RefreshDatabase::class);

ModelExpectation::hasRelations(
    Questionnaire::class,
    belongsTo: [
        'questionnaireGroup',
        'subject',
        'prototype',
    ],
    hasMany: [
        'questions',
    ],
    belongsToMany: [
        'students',
    ],
);

it('has factory', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire->id)->not()->toBeNull();
});

it('has students who answered', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(5)->createWith();
    $students = Student::factory()->count(10)->create();

    foreach ($students as $student) {
        foreach ($questions as $question) {
            $c = random_int(0, 1);

            $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
        }
    }

    expect($questionnaire->students->count())->toBe($students->count());
});

it('has a stats service', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire->stats())->toBeInstanceOf(QuestionnaireStatsService::class);
});

it('has default name attribute', function () {
    $questionnaire = Questionnaire::factory()->create(['name' => null]);

    expect($questionnaire->name)->not()->toBeNull();
});

it('has overridden name attribute', function () {
    $questionnaire = Questionnaire::factory()->create(['name' => 'Test']);

    expect($questionnaire->name)->toBe('Test');
});

it('belongs to a period', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire->period)->not()->toBeNull();
});

it('has a grading service', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire->grading())->toBeInstanceOf(GradingService::class);
});
