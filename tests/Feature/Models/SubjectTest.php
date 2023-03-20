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

    expect($subject)->toContain('order by `name` asc');
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
    expect(Subject::class)->toHasMany('questionnaires', Questionnaire::class);
});

it('has many divisions', function () {
    expect(Subject::class)->toHasMany('divisions', Division::class);
});

it('has many question prototypes', function () {
    expect(Subject::class)->toHasMany('questionPrototypes', QuestionPrototype::class);
});

it('may belongs to a parent subject', function () {
    expect(Subject::class)->toMayBelongsTo('parent', Subject::class);
});

it('has many questionnaire prototypes', function () {
    expect(Subject::class)->toHasMany('questionnairePrototypes', QuestionnairePrototype::class);
});
