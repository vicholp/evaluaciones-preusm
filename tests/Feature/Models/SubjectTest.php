<?php

use App\Models\Division;
use App\Models\Questionnaire;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    Subject::factory()->create();

    expect(Subject::count())->toBe(1);
});

it('has many questionnaires', function () {
    $subject = Subject::factory()->create();

    Questionnaire::factory()->for($subject)->count(3)->create();

    expect($subject->questionnaires->count())->toBe(3);
});

it('has many divisions', function () {
    $subject = Subject::factory()->create();

    Division::factory()->for($subject)->count(3)->create();

    expect($subject->divisions->count())->toBe(3);
});
