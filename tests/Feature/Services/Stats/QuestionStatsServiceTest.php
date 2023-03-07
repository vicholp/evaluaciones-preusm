<?php

use App\Models\Question;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('average score', function () {
    $question = Question::factory()->state(['pilot' => false])->create();
    addAlternativesToQuestion($question);

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
    $question = Question::factory()->pilot()->create();
    addAlternativesToQuestion($question);

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
    $question = Question::factory()->create();
    addAlternativesToQuestion($question);

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
