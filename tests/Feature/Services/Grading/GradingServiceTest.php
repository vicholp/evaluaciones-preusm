<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Support\Facades\Artisan;

beforeEach(function() {
    Artisan::call('migrate:fresh');
});

test('count gradeable questions', function () {
    $questionnaire = Questionnaire::factory()->create();

    Question::factory()->for($questionnaire)->count(1)->pilot()->create();
    Question::factory()->for($questionnaire)->count(2)->create();

    expect($questionnaire->grading()->gradableQuestions())->toBe(2);
    expect($questionnaire->grading()->pilotQuestions())->toBe(1);
});

test('grade in questionnaire without pilot questions', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(4)->create();
    $student = Student::factory()->create();

    foreach (Question::get() as $question) {
        $alternative = Alternative::factory()->for($question)->correct()->create();
        $student->alternatives()->attach($alternative);
    }

    expect($questionnaire->grading()->getGrade($student->stats()->scoreInQuestionnaire($questionnaire)))->toBe(1000);
    expect($student->stats()->scoreInQuestionnaire($questionnaire))->toBe(4);
});

test('grade in questionnaire with pilot question', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(4)->create();
    $student = Student::factory()->create();

    foreach (Question::get() as $question) {
        $alternative = Alternative::factory()->for($question)->correct()->create();
        $student->alternatives()->attach($alternative);
    }

    // pilot question
    $question = Question::factory()->for($questionnaire)->pilot()->create();
    $alternative = Alternative::factory()->for($question)->create();
    $student->alternatives()->attach($alternative);

    expect($questionnaire->grading()->getGrade($student->stats()->scoreInQuestionnaire($questionnaire)))->toBe(1000);
    expect($student->stats()->scoreInQuestionnaire($questionnaire))->toBe(4);
});
