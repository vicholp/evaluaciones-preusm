<?php

use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Services\Stats\QuestionnaireGroupStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    expect($questionnaireGroup->id)->toBeGreaterThan(0);
});

it('belongs to period', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    expect($questionnaireGroup->period)->not()->toBe(null);
});

it('has many questionnaires', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    Questionnaire::factory()->count(3)->for($questionnaireGroup)->create();

    expect($questionnaireGroup->questionnaires->count())->toBe(3);
});

it('belongs to questionnaire class', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    expect($questionnaireGroup->questionnaireClass)->not()->toBe(null);
});

it('has stats service', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    expect($questionnaireGroup->stats())->toBeInstanceOf(QuestionnaireGroupStatsService::class);
});

it('has default name attribute', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();

    expect($questionnaireGroup->name)->not()->toBe(null);
});

it('has overridden name attribute', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create([
        'name' => 'Test name',
    ]);

    expect($questionnaireGroup->name)->toBe('Test name');
});


