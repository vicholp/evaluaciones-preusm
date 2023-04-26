<?php

use App\Models\QuestionnaireGroup;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has show', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaire-groups.show', $questionnaireGroup))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire-group.show')
        ->assertViewHas('questionnaireGroup', $questionnaireGroup);
});
