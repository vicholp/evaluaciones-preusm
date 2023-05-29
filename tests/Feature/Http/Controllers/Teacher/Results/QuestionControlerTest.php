<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('show', function () {
    $questionnaire = Questionnaire::factory()->createWithAnswers();
    $question = $questionnaire->questions()->inRandomOrder()->first();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questions.show', $question))
        ->assertOk()
        ->assertViewIs('teacher.results.question.show')
        ->assertViewHas('question', $question);
});

test('mark as pilot', function () {
    $question = Question::factory()
        ->state(['pilot' => false])->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questions.mark-as-pilot', $question))
        ->assertRedirect(route('teacher.results.questions.show', $question));

    $question = $question->fresh();
    expect($question->pilot)->toBe(1);
    expect($question->stats()->isUpdated())->toBe(false);
});

test('unmark as pilot', function () {
    $question = Question::factory()
        ->state(['pilot' => true])->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questions.unmark-as-pilot', $question))
        ->assertRedirect(route('teacher.results.questions.show', $question));

    $question = $question->fresh();
    expect($question->pilot)->toBe(0);
    expect($question->stats()->isUpdated())->toBe(false);
});
