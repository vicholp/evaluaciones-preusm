<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\AnswerQuestionnaireByStudent;

uses(RefreshDatabase::class);

test('average score', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(5)->createWith();
    $students = Student::factory()->count(10)->create();

    $sum = 0;
    foreach ($students as $student) {
        $correct = 0;
        foreach ($questions as $question) {
            $c = random_int(0, 1);

            if (!$question->pilot) {
                $correct += $c;
            }

            $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
        }
        $sum += $correct;
    }

    expect($questionnaire->stats()->getAverageScore())->toBe((float) ($sum / $students->count()));
});

test('sent count', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(3)->createWith();
    $students = Student::factory()->count(10)->create();

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
    $questions = Question::factory()->count(3)->for($questionnaire)->createWith();

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

test('all', function () {
    $students = Student::factory()->count(5)->create();
    $questionnaire = Questionnaire::factory()->createWith(questions: 5);

    foreach ($students as $student) {
        AnswerQuestionnaireByStudent::call($questionnaire, $student);
    }

    expect($questionnaire->stats)->toBe(null);

    $questionnaire->stats()->all();

    expect($questionnaire->getAttributes()['stats'])->not()->toBe(null);

    foreach ($questionnaire->students as $student) {
        $student = $student->fresh()->questionnaires()->whereQuestionnaireId($questionnaire->id)->first();

        expect($student->getAttributes()['stats'])->not()->toBe(null);
    }
});

test('clear', function () {
    $students = Student::factory()->count(5)->create();
    $questionnaire = Questionnaire::factory()->createWith(questions: 5);

    foreach ($students as $student) {
        AnswerQuestionnaireByStudent::call($questionnaire, $student);
    }

    expect($questionnaire->stats)->toBe(null);

    $questionnaire->stats()->all();

    expect($questionnaire->getAttributes()['stats'])->not()->toBe(null);

    $questionnaire->stats()->clear();

    expect($questionnaire->getAttributes()['stats'])->toBe(null);

    foreach ($questionnaire->students as $student) {
        $student = $student->fresh()->questionnaires()->whereQuestionnaireId($questionnaire->id)->first();

        expect($student->getAttributes()['stats'])->toBe(null);
    }
});
