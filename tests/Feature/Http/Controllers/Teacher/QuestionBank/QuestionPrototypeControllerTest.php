<?php

use App\Models\QuestionPrototype;
use App\Models\Tag;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('index action', function () {
    test('when there are questions', function () {
        $questions = QuestionPrototype::factory()->count(3)->hasVersions()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.question-prototypes.index'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.question.index')
            ->assertViewHas('questions', $questions);
    });

    test('when there are no questions', function () {
        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.question-prototypes.index'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.question.index')
            ->assertViewHas('questions');
    });
});

describe('create action', function () {
    it('shows form', function () {
        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.question-prototypes.create'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.question.create');
    });
});

describe('store action', function () {
    test('when question has no statement', function () {
        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)

            ->post(route('teacher.question-bank.question-prototypes.store'), [
                'subject_id' => 1,
                'statement' => null,
                'description' => 'description',
                'name' => 'name',
                'body' => 'body',
                'answer' => 'answer',
                'tags' => [],
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.question.show')
            ->assertViewHas('question');
    });
});

describe('show action', function () {
    test('when question has no prototype', function () {
        $questionPrototype = QuestionPrototype::factory()
                                ->withoutStatement()->hasVersions()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.question-prototypes.show', $questionPrototype))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.question.show')
            ->assertViewHas('question', $questionPrototype);
    });

    test('when question has statement', function () {
        $questionPrototype = QuestionPrototype::factory()->withStatement()
                                ->hasVersions()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.question-prototypes.show', $questionPrototype))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.question.show')
            ->assertViewHas('question', $questionPrototype);
    });

    test('when question has tags', function () {
        $questionPrototype = QuestionPrototype::factory()->hasVersions()->create();

        $latest = $questionPrototype->latest;

        $latest->tags()->attach(
            Tag::factory()->count(3)->create()
        );

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.question-prototypes.show', $questionPrototype))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.question.show')
        ->assertViewHas('question', $questionPrototype);
    });
});
