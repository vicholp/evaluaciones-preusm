<?php

use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use App\Services\Results\QuestionnaireService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create questions with alternatives', function () {
    $question = Questionnaire::factory()->create();

    $service = new QuestionnaireService($question);

    $questions = $service->createQuestionsWithAlternatives(5);

    expect($questions)->toHaveCount(5);
    expect($question->questions)->toHaveCount(5);
});

test('create', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    $subject = Subject::forQuestionnaires()->inRandomOrder()->first();

    $questionnaire = QuestionnaireService::create(
        fake()->name,
        $questionnaireGroup->id,
        $subject->id,
        5
    );

    expect($questionnaire->questions)->toHaveCount(5);

    $questionnaire = QuestionnaireService::create(
        null,
        $questionnaireGroup->id,
        $subject->id,
        5
    );

    expect($questionnaire->questions)->toHaveCount(5);
});

test('create from prototype', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    $subject = Subject::forQuestionnaires()->inRandomOrder()->first();
    $questionnairePrototype = QuestionnairePrototype::factory()->forSubject($subject)->hasVersions(2)->create();
    $questionPrototypes = QuestionPrototype::factory()->count(5)->hasVersions(2)->create();

    for ($i = 0; $i < 5; ++$i) {
        $questionPrototype = $questionPrototypes[$i];
        $questionnairePrototype->latest->questions()->attach($questionPrototype->latest->id, [
            'position' => $i + 1,
        ]);
    }

    $questionnaire = QuestionnaireService::createFromPrototype(
        fake()->name,
        $questionnaireGroup,
        $questionnairePrototype->latest
    );

    expect($questionnaire->questions)->toHaveCount(5);
    expect($questionnaire->prototype->id)->toBe($questionnairePrototype->latest->id);

    $questions = $questionnairePrototype->latest->questions;

    for ($i = 0; $i < 5; ++$i) {
        $questionPrototype = $questions[$i];
        expect($questionnaire->questions[$i]->prototype->id)->toBe($questionPrototype->id);
        expect($questionnaire->questions[$i]->data)->toBe($questionPrototype->body);
    }
});
