<?php

use App\Models\QuestionPrototype;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has index', function () {
    $this->get(route('teacher.question-bank.question-prototypes.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.index');
});

it('has create', function () {
    $this->get(route('teacher.question-bank.question-prototypes.create'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.create');
});

it('has show', function () {
    $questionPrototype = QuestionPrototype::factory()->hasVersions()->create();

    $this->get(route('teacher.question-bank.question-prototypes.show', $questionPrototype))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.show')
        ->assertSee($questionPrototype->latest->name);
});

it('has edit', function () {
    $questionPrototype = QuestionPrototype::factory()->hasVersions()->create();

    $this->get(route('teacher.question-bank.question-prototypes.edit', $questionPrototype))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.edit')
        ->assertSee($questionPrototype->latest->name);
});
