<?php

use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('index', function () {
    $questionnaire = Questionnaire::factory()->create();

    $response = $this->get(route('teacher.index'));

    $response->assertStatus(200);
    $response->assertSee($questionnaire->questionnaireGroup->name);
});
