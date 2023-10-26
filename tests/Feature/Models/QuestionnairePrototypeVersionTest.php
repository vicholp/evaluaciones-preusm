<?php

use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototypeVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Expectations\ModelExpectation;

uses(RefreshDatabase::class);

ModelExpectation::hasRelations(
    QuestionnairePrototypeVersion::class,
    hasMany: ['implementations'],
    useFactory: true,
);

it('has sorted questions', function () {
    $questionnairePrototypeVersion = QuestionnairePrototypeVersion::factory()->create();
    $questions = QuestionPrototypeVersion::factory()->count(10)->create();
    $questions = $questions->shuffle();

    for ($i = 0; $i < 10; ++$i) {
        $questionnairePrototypeVersion->questions()->attach($questions[$i], [
            'position' => $i + 1,
        ]);
    }

    expect($questions->pluck('id'))
        ->toEqualCanonicalizing($questionnairePrototypeVersion->questions->pluck('id'));
    expect($questionnairePrototypeVersion->questions->pluck('pivot.position'))
        ->toEqualCanonicalizing(collect(range(1, 10)));
});
