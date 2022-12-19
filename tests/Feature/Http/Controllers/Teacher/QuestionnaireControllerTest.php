<?php

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has show', function () {
    $questionnaire = Questionnaire::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('teacher.questionnaires.show', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.questionnaire.show')
        ->assertSee($questionnaire->name);
});
