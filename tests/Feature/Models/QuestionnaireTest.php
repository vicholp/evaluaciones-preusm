<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use App\Models\Subject;
use App\Services\Grading\GradingService;
use App\Services\Stats\QuestionnaireStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    $questionnaire = Questionnaire::factory()->create();

    expect($questionnaire->id)->not()->toBeNull();
});

it('has questions', function () {
    $questionnaire = Questionnaire::factory()->create();

    $questions = Question::factory()->for($questionnaire)->count(5)->create();

    expect($questionnaire->questions->count())->toBe($questions->count());
});

it('has students who answered', function () {
    $questionnaire = Questionnaire::factory()->create();

    $questions = Question::factory()->for($questionnaire)->count(5)->create();

    $students = Student::factory()->count(10)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }

    foreach ($students as $student) {
        foreach ($questions as $question) {
            $c = random_int(0, 1);

            $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
        }
    }

    expect($questionnaire->students->count())->toBe($students->count());
});

it('belongs to a subject', function () {
    $subject = Subject::inRandomOrder()->first();
    $questionnaire = Questionnaire::factory()->for($subject)->create();

    expect($questionnaire->subject->id)->toBe($subject->id);
});

it('belongs to a questionnaire group', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    $questionnaire = Questionnaire::factory()->for($questionnaireGroup)->create();

    expect($questionnaire->questionnaireGroup->id)->toBe($questionnaireGroup->id);
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
