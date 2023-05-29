<?php

use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create one with questions', function () {
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

    expect($questionnaire->questions()->count())->toBe(15);

    foreach ($questionnaire->questions as $question) {
        expect($question->alternatives()->count())->toBe(6);
        expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
        expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
    }
});

test('create many with questions', function () {
    $questionnaires = Questionnaire::factory()->count(5)->createWithQuestions(15);

    expect($questionnaires->pluck('id'))->toEqualCanonicalizing(Questionnaire::get()->pluck('id'));

    foreach ($questionnaires as $questionnaire) {
        expect($questionnaire->questions()->count())->toBe(15);

        foreach ($questionnaire->questions as $question) {
            expect($question->alternatives()->count())->toBe(6);
            expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
            expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
        }
    }
});

test('create with answers', function () {
    $questionnaire = Questionnaire::factory()->createWithAnswers();

    expect($questionnaire->questions()->count())->toBe(15);
    expect($questionnaire->students()->count())->toBe(3);

    foreach ($questionnaire->questions as $question) {
        expect($question->alternatives()->count())->toBe(6);
        expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
        expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
        expect($question->students()->count())->toBe(3);
    }
});

test('create with n answers', function () {
    $questionnaire = Questionnaire::factory()->createWithAnswers(students_count: 2);

    expect($questionnaire->questions()->count())->toBe(15);
    expect($questionnaire->students()->count())->toBe(2);

    foreach ($questionnaire->questions as $question) {
        expect($question->alternatives()->count())->toBe(6);
        expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
        expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
        expect($question->students()->count())->toBe(2);
    }
});

test('create with answers from students', function () {
    $students = Student::factory()->count(3)->create();

    $questionnaire = Questionnaire::factory()->createWithAnswers(students: $students);

    expect($questionnaire->questions()->count())->toBe(15);
    expect($questionnaire->students()->count())->toBe(3);
    expect($questionnaire->students()->get()->pluck('id'))->toEqualCanonicalizing($students->pluck('id'));

    foreach ($questionnaire->questions as $question) {
        expect($question->alternatives()->count())->toBe(6);
        expect($question->alternatives()->whereCorrect(true)->count())->toBe(1);
        expect($question->alternatives()->whereName('N/A')->count())->toBe(1);
        expect($question->students()->count())->toBe(3);
    }
});
