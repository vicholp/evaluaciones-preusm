<?php

use App\Models\QuestionnairePrototype;
use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototypeVersion;
use App\Models\StatementPrototype;
use App\Models\Subject;
use App\Services\QuestionBank\QuestionnairePrototypeService;
use App\Services\QuestionBank\QuestionPrototypeService;

describe('create new questionnaire', function () {
    test('create questionnaire and attach a version', function () {
        $subject = Subject::inRandomOrder()->first();

        $questionnaire = QuestionnairePrototypeService::create(
            'name',
            'description',
            $subject
        );

        expect($questionnaire->versions()->count())->toBe(1);
        expect($questionnaire->latest->name)->toBe('name');
        expect($questionnaire->latest->description)->toBe('description');
    });
});

describe('last position', function () {
    test('when there are no questions', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        expect($questionnaireService->lastPosition())->toBe(0);
    });
    test('when there is a question', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $question = QuestionPrototypeVersion::factory()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $questionnaireService->attachQuestion($question);

        expect($questionnaireService->lastPosition())->toBe(1);
    });
    test('when there is a statement', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $statement = StatementPrototype::factory()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $questionnaireService->attachStatement($statement);

        expect($questionnaireService->lastPosition())->toBe(1);
    });
});

describe('attach new question', function () {
    test('when it does not have questions, it attach it', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $question = QuestionPrototypeVersion::factory()->create();

        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $questionnaireService->attachQuestion($question);

        expect($questionnaire->latest->questions()->count())->toBe(1);
        expect($questionnaire->latest->questions->first()->id)->toBe($question->id);
        expect($questionnaire->latest->questions->first()->pivot->position)->toBe(1);
    });

    test('when there is questions, it attach at the end', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $question = QuestionPrototypeVersion::factory()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $questionnaireService->attachQuestion($question);
        $questionnaireService->attachQuestion($question);

        $question2 = QuestionPrototypeVersion::factory()->create();

        $questionnaireService->attachQuestion($question2);

        expect($questionnaire->latest->questions()->count())->toBe(3);
        expect($questionnaire->latest->questions->last()->id)->toBe($question2->id);
        expect($questionnaire->latest->questions->last()->pivot->position)->toBe(3);
    });
});

describe('attach statement', function () {
    test('when questionnaire is empty', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $statement = StatementPrototype::factory()->create();

        $questionnaireService->attachStatement($statement);

        expect($questionnaire->latest->statements()->count())->toBe(1);
        expect($questionnaire->latest->statements->first()->id)->toBe($statement->id);
        expect($questionnaire->latest->statements->first()->pivot->position)->toBe(1);
    });

    test('when there are questions and statements', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $questionnaireService = new QuestionnairePrototypeService($questionnaire);

        $statement = StatementPrototype::factory()->create();

        $questionnaireService->attachStatement($statement);

        $question = QuestionPrototypeVersion::factory()->create();

        $questionnaireService->attachQuestion($question);

        $statement2 = StatementPrototype::factory()->create();

        $questionnaireService->attachStatement($statement2);

        expect($questionnaire->latest->statements()->count())->toBe(2);
        expect($questionnaire->latest->statements->last()->id)->toBe($statement2->id);
        expect($questionnaire->latest->statements->last()->pivot->position)->toBe(3);
    });
});

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

test('update question in questionnaire', function () {
    $latest = QuestionnairePrototypeVersion::factory()->create();
    $questionnaire = $latest->parent;

    $questionnaireService = new QuestionnairePrototypeService($questionnaire);
    $questions = QuestionPrototypeVersion::factory()->count(3)->create();

    $questionnaireService->createNewVersion($questions);

    $updated = $questions[0]->parent;

    $questionService = new QuestionPrototypeService($updated);

    $latestQuestion = $questionService->createNewVersion('body', 'answer');

    $questions[0] = $latestQuestion;

    $questionnaireService->updateQuestionInQuestionnaire($updated);

    expect($questionnaire->latest->questions()->count())->toBe(3);
    expect($questionnaire->latest->questions->pluck('id'))
        ->toEqualCanonicalizing($questions->pluck('id'));
});
