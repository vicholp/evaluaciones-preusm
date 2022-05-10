<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Artisan;

beforeEach(function() {
    Artisan::call('migrate:fresh');
});

test('answer to question', function () {
    $question = Question::factory()->create();

    $student = Student::factory()->create();

    Alternative::factory()->for($question)->count(2)->state(new Sequence(
        ['correct' => true],
        ['correct' => false],
    ))->create();

    $alternative = Alternative::whereCorrect(true)->first();

    $student->alternatives()->attach($alternative);

    expect($student->stats()->answerToQuestion($question)->id)->toBe($alternative->id);
});

test('score in normal question', function () {
    $question = Question::factory()->create();

    $student = Student::factory()->create();

    Alternative::factory()->for($question)->count(2)->state(new Sequence(
        ['correct' => true],
        ['correct' => false],
    ))->create();

    $alternative = Alternative::whereCorrect(true)->first();

    $student->alternatives()->attach($alternative);

    expect($student->stats()->scoreInQuestionnaire($question->questionnaire))->toBe(1);
});

test('score in pilot question', function () {
    $question = Question::factory()->pilot()->create();

    $student = Student::factory()->create();

    Alternative::factory()->for($question)->count(2)->state(new Sequence(
        ['correct' => true],
        ['correct' => false],
    ))->create();

    $alternative = Alternative::whereCorrect(true)->first();

    $student->alternatives()->attach($alternative);

    expect($student->stats()->scoreInQuestionnaire($question->questionnaire))->toBe(0);
});

test('did not sent questionnaire', function() {
    $questionnaire = Questionnaire::factory()->hasQuestions(1)->create();
    $student = Student::factory()->create();

    expect($student->stats()->sentQuestionnaire($questionnaire))->toBeFalse();
});

test('sent questionnaire', function() {
    $alternative = Alternative::factory()->create();
    $student = Student::factory()->create();
    $student->alternatives()->attach($alternative);

    expect($student->stats()->sentQuestionnaire($alternative->question->questionnaire))->toBeTrue();
});



