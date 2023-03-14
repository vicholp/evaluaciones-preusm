<?php

use App\Models\Division;
use App\Models\Questionnaire;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('was seeded', function () {
    expect(Subject::count())->toBe(21);
});

it('has alphabetical order scope', function () {
    $subject = Subject::toSql();

    expect($subject)->toContain('order by "name" asc');
});

it('has for questions scope', function () {
    $subject = Subject::forQuestions()->getBindings();

    expect($subject)->toBe([
        'ciencias biologia comun',
        'ciencias biologia electivo',
        'ciencias biologia tp',
        'ciencias quimica comun',
        'ciencias quimica electivo',
        'ciencias quimica tp',
        'ciencias fisica comun',
        'ciencias fisica electivo',
        'ciencias fisica tp',
        'matematicas 1',
        'matematicas 2',
        'lenguaje',
        'historia',
    ]);
});

it('has for questionnaires scope', function () {
    $subject = Subject::forQuestionnaires()->getBindings();

    expect($subject)->toBe([
        'matematicas 1',
        'matematicas 2',
        'ciencias biologia',
        'ciencias fisica',
        'ciencias quimica',
        'ciencias TP',
        'historia',
        'lenguaje',
    ]);
});

it('has for questionnaire prototypes scope', function () {
    $subject = Subject::forQuestionnairePrototypes()->getBindings();

    expect($subject)->toBe([
        'matematicas terceros',
        'matematicas 1',
        'matematicas 2',
        'ciencias biologia',
        'ciencias biologia comun',
        'ciencias biologia electivo',
        'ciencias biologia TP',
        'ciencias fisica',
        'ciencias fisica comun',
        'ciencias fisica electivo',
        'ciencias fisica TP',
        'ciencias quimica',
        'ciencias quimica comun',
        'ciencias quimica electivo',
        'ciencias quimica TP',
        'ciencias TP',
        'historia',
        'lenguaje',
    ]);
});

it('has many questionnaires', function () {
    $subject = Subject::inRandomOrder()->first();

    Questionnaire::factory()->for($subject)->count(3)->create();

    expect($subject->questionnaires->count())->toBe(3);
});

it('has many divisions', function () {
    $subject = Subject::inRandomOrder()->first();

    Division::factory()->for($subject)->count(3)->create();

    expect($subject->divisions->count())->toBe(3);
});

it('has many question prototypes', function () {
    $subject = Subject::inRandomOrder()->first();

    QuestionPrototype::factory()->for($subject)->count(3)->create();

    expect($subject->questionPrototypes->count())->toBe(3);
});

it('has many questionnaire prototypes', function () {
    $subject = Subject::inRandomOrder()->first();

    QuestionnairePrototype::factory()->for($subject)->count(3)->create();

    expect($subject->questionnairePrototypes->count())->toBe(3);
});

it('has a parent subject', function () {
    $subject = Subject::whereSubjectId(null)->first();

    expect($subject->parent)->toBeNull();

    $subject = Subject::whereNotNull('subject_id')->first();

    expect($subject->parent->id)->not()->toBeNull();
});
