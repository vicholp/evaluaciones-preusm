<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('average score', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(5)->create();
    $students = Student::factory()->count(10)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }
    $sum = 0;
    foreach ($students as $student) {
        $correct = 0;
        foreach ($questions as $question) {
            $c = random_int(0, 1);
            $correct += $c;

            $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
        }
        $sum += $correct;
    }

    expect($questionnaire->stats()->getAverageScore())->toBe($sum / $students->count());
});

test('sent count', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(3)->create();
    $students = Student::factory()->count(10)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }

    $count = 0;

    foreach ($students as $student) {
        if (!rand(0, 1)) {
            continue;
        }
        $student->attachAlternative($questions[rand(0, 2)]->alternatives()->first());
        ++$count;
    }

    expect($questionnaire->stats()->getSentCount())->toBe($count);
});

test('students sent', function () {
    $questionnaire = Questionnaire::factory()->create();
    $students = Student::factory()->count(10)->create();
    $questions = Question::factory()->count(3)->for($questionnaire)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }

    $studentsSent = [];

    foreach ($students as $student) {
        if (rand(0, 1)) {
            $studentsSent[$student->id] = 1;
            $student->attachAlternative($questions[rand(0, 2)]->alternatives()->inRandomOrder()->first());
        }
    }

    $studentsSent = array_keys($studentsSent);

    expect($questionnaire->stats()->getStudentsSent())->toBe($studentsSent);
});
