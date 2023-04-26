<?php

use App\Models\Questionnaire;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('index', function () {
    $questionnaire = Questionnaire::factory()->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.index'))
        ->assertStatus(200)
        ->assertSee($questionnaire->questionnaireGroup->name);
});
