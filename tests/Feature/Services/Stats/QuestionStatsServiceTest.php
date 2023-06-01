<?php

use App\Models\Question;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\AnswerQuestionByStudent;

uses(RefreshDatabase::class);

test('average score', function () {
    $question = Question::factory()->state(['pilot' => false])->createWith();

    $students = Student::factory()->count(10)->create();

    $correct = 0;
    foreach ($students as $student) {
        $c = random_int(0, 1);
        $correct += $c;

        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($question->stats()->getAverageScore())->toBe($correct / $students->count());
});

test('average score on pilot question', function () {
    $question = Question::factory()->pilot()->createWith();

    $students = Student::factory()->count(10)->create();

    $correct = 0;
    foreach ($students as $student) {
        $c = random_int(0, 1);
        $correct += $c;
        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($question->stats()->getAverageScore())->toBe($correct / $students->count());
});

test('null index', function () {
    $question = Question::factory()->createWith();

    $students = Student::factory()->count(10)->create();

    $null = 0;

    foreach ($students as $student) {
        $n = random_int(0, 1);

        if ($n) {
            ++$null;
            $student->attachAlternative($question->alternatives()->whereName('N/A')->first());
        } else {
            $student->attachAlternative($question->alternatives()->where('name', '!=', 'N/A')->inRandomOrder()->first());
        }
    }

    expect($question->stats()->getNullIndex())->toBe($null / $students->count());
});

test('answer count', function () {
    $students = Student::factory()->count(10)->create();
    $question = Question::factory()->createWith();

    foreach ($students as $student) {
        AnswerQuestionByStudent::call($question, $student);
    }

    expect($question->stats()->getAnswerCount())->toBe(10);
});

test('facility index', function () {
    $question = Question::factory()->createWith();

    $students = Student::factory()->count(10)->create();

    $correct = 0;
    foreach ($students as $student) {
        $c = random_int(0, 1);
        $correct += $c;
        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($question->stats()->getFacilityIndex())->toBe(0.0);
});

test('marked count on alternatives', function () {
    $students = Student::factory()->count(10)->create();
    $question = Question::factory()->createWith();

    foreach ($students as $student) {
        AnswerQuestionByStudent::call($question, $student);
    }

    foreach ($question->alternatives as $alternative) {
        expect($question->stats()->getMarkedCountOnAlternative($alternative))->toBe($alternative->students->count());
    }
});

test('marked percentage on alternatives', function () {
    $students = Student::factory()->count(10)->create();
    $question = Question::factory()->createWith();

    foreach ($students as $student) {
        AnswerQuestionByStudent::call($question, $student);
    }

    foreach ($question->alternatives as $alternative) {
        expect($question->stats()->getMarkedPercentageOnAlternative($alternative))->toBe((float) ($alternative->students->count() / $students->count()) * 100);
    }
});

test('marked percentage on alternatives without answers', function () {
    $question = Question::factory()->createWith();

    foreach ($question->alternatives as $alternative) {
        expect($question->stats()->getMarkedPercentageOnAlternative($alternative))->toBe(0.0);
    }
});
