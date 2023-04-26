<?php

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has show', function () {
    $questionnaire = createAndAnswerQuestionnaire();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.show', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire.show')
        ->assertViewHas('questionnaire', $questionnaire);
});
