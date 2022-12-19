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

    expect($question->stats()->getAverageScore())->toBe($correct);
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

    expect($question->stats()->getAverageScore())->toBe($correct);
});
