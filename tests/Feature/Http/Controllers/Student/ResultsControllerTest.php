<?php

use App\Models\Period;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Period::factory()->create();
});

test('questionnaireGroup', function () {
    $student = Student::factory()->create()->user;

    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    $this->actingAs($student)
        ->get(route('student.results.questionnaire-group', $questionnaireGroup))
        ->assertOk()
        ->assertViewIs('student.results.questionnaire-group');
});

test('questionnaire', function () {
    $student = Student::factory()->create()->user;

    $questionnaire = Questionnaire::factory()->createWith();

    $this->actingAs($student)
        ->get(route('student.results.questionnaire', $questionnaire))
        ->assertOk()
        ->assertViewIs('student.results.questionnaire');
});
