<?php

use App\Models\StatementPrototype;
use App\Models\Teacher;

describe('index action', function () {
    test('when there are statements', function () {
        $statements = StatementPrototype::factory()->count(3)->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.index'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.index')
            ->assertViewHas('statements', $statements);
    });
    test('when there are no statements', function () {
        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.index'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.index')
            ->assertViewHas('statements');
    });
});

describe('show action', function () {
    test('when statement has no questions', function () {
        $statement = StatementPrototype::factory()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.show', $statement))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.show')
            ->assertViewHas('statement', $statement);
    });
    test('when statement has questions', function () {
        $statement = StatementPrototype::factory()->hasQuestions()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.show', $statement))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.show')
            ->assertViewHas('statement', $statement);
    });
});

describe('create action', function () {
    test('it shows view', function () {
        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.create'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.create');
    });
});

describe('store action', function () {
    test('it store statement', function () {
        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->post(route('teacher.question-bank.statement-prototypes.store'), [
                'subject_id' => 1,
                'body' => 'statement',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.statement.show')
            ->assertViewHas('statement');
    });
});

describe('edit action', function () {
    test('it shows view', function () {
        $statement = StatementPrototype::factory()->create();

        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.statement-prototypes.edit', $statement))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.statement.edit')
            ->assertViewHas('statement', $statement);
    });
});

describe('update action', function () {
    test('it update statement', function () {
        $statement = StatementPrototype::factory()->create();

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->put(route('teacher.question-bank.statement-prototypes.update', $statement), [
                'body' => 'statement',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.statement.show')
            ->assertViewHas('statement');
    });
});
