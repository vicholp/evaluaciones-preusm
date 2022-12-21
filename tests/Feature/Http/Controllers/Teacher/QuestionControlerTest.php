<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('show', function () {
    $questionnaire = createAndAnswerQuestionnaire();
    $question = $questionnaire->questions()->inRandomOrder()->first();

    $this->get(route('teacher.questions.show', $question))
        ->assertOk()
        ->assertViewIs('teacher.question.show')
        ->assertSee($question->name)
        ->assertSee($question->alternatives->first()->name);
});
