<?php

use App\Models\QuestionnairePrototype;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CreateQuestionnairePrototypeFullHelper;

uses(RefreshDatabase::class);

it('index', function () {
    $questionnaires = QuestionnairePrototype::factory()
        ->count(3)
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.index')
        ->assertViewHas('questionnaires', $questionnaires);
});

it('show', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.show')
        ->assertViewHas('questionnaire', $questionnaire);
});

it('create', function () {
    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.create'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.create');
});

it('store', function () {
    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->post(route('teacher.question-bank.questionnaire-prototypes.store'), [
            'subject_id' => 1,
        ])
        ->assertRedirect(route('teacher.question-bank.questionnaire-prototypes.show', QuestionnairePrototype::first()));
});

it('edit', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.edit', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.edit')
        ->assertViewHas('questionnaire', $questionnaire);
});

it('update', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->put(route('teacher.question-bank.questionnaire-prototypes.update', $questionnaire), [
            'subject_id' => 1,
        ])
        ->assertRedirect(route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire));
});

it('has export sheet to xslx', function () {
    Excel::fake();

    $questionnairePrototype = CreateQuestionnairePrototypeFullHelper::call();
    $latest = $questionnairePrototype->latest;

    $teacher = Teacher::factory()->create();

    $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.questionnaire-prototypes.export-sheet-xlsx', $latest))
        ->assertOk();

    Excel::assertDownloaded('ficha.xlsx');
});
