<?php

use App\Models\Questionnaire;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has show', function () {
    $questionnaire = Questionnaire::factory()->createWithAnswers();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.show', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire.show')
        ->assertViewHas('questionnaire', $questionnaire);
});

test('update stats', function () {
    $questionnaire = Questionnaire::factory()->createWithAnswers();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.update-stats', $questionnaire))
        ->assertRedirect();

    $questionnaire = $questionnaire->fresh();
    expect($questionnaire->getAttributes()['stats'])->toBe(null);
});
