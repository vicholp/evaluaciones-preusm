<?php

use App\Models\Division;
use App\Models\Period;
use App\Models\QuestionnaireGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    Period::factory()->create();

    expect(Period::count())->toBe(1);
});

it('has questionnaire groups', function () {
    $period = Period::factory()->create();

    QuestionnaireGroup::factory()->count(3)->for($period)->create();

    expect($period->questionnaireGroups->count())->toBe(3);
});

it('has divisions', function () {
    $period = Period::factory()->create();

    Division::factory()->count(3)->for($period)->create();

    expect($period->divisions->count())->toBe(3);
});
