<?php

use App\Models\QuestionnaireGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has show', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('teacher.questionnaire-groups.show', $questionnaireGroup))
        ->assertOk()
        ->assertViewIs('teacher.questionnaire-group.show')
        ->assertSee($questionnaireGroup->name);
});
