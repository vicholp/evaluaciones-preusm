<?php

use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototypeVersion;
use App\Services\QuestionBank\QuestionnairePrototypeService;
use App\Services\QuestionBank\QuestionPrototypeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create new version', function () {
    $latest = QuestionnairePrototypeVersion::factory()->create();
    $questions = QuestionPrototypeVersion::factory()->count(3)->create();
    $service = new QuestionnairePrototypeService($latest->parent);
    $questionnaire = $latest->parent;

    $service->createNewVersion($questions);

    expect($questionnaire->versions()->count())->toBe(2);
    expect($questionnaire->latest->questions()->count())->toBe(3);
    expect($questionnaire->latest->questions->pluck('id'))
        ->toEqualCanonicalizing($questions->pluck('id'));
});
