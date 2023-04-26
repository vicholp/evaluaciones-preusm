<?php

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('show', function () {
    $questionnaire = createAndAnswerQuestionnaire();
    $question = $questionnaire->questions()->inRandomOrder()->first();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questions.show', $question))
        ->assertOk()
        ->assertViewIs('teacher.results.question.show')
        ->assertViewHas('question', $question);
});
