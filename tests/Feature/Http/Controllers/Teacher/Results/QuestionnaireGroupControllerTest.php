<?php

use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('show empty questionnaire group', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaire-groups.show', $questionnaireGroup))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire-group.show')
        ->assertViewHas('questionnaireGroup', $questionnaireGroup);
});

it('show questionnaire group with questionnaires', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    Questionnaire::factory()->count(5)->for($questionnaireGroup)->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaire-groups.show', $questionnaireGroup))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire-group.show')
        ->assertViewHas('questionnaireGroup', $questionnaireGroup);
});
