<?php

use App\Models\QuestionPrototype;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has index', function () {
    $questions = QuestionPrototype::factory()->count(3)->hasVersions()->create();

    $teacher = Teacher::factory()->create();

    $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.question-prototypes.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.index')
        ->assertViewHas('questions', $questions);
});

it('has create', function () {
    $teacher = Teacher::factory()->create();

    $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.question-prototypes.create'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.create');
});

it('has show', function () {
    $questionPrototype = QuestionPrototype::factory()->hasVersions()->create();

    $teacher = Teacher::factory()->create();

    $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.question-prototypes.show', $questionPrototype))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.show')
        ->assertViewHas('question', $questionPrototype);
});
