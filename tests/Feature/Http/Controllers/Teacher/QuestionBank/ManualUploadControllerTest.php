<?php

use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Teacher;
use App\Services\QuestionBank\ManualUploadService;

describe('start upload', function () {
    it('shows view', function () {
        $teacher = Teacher::factory()->create();

        $this->actingAs($teacher->user)
            ->get(route('teacher.question-bank.manual-upload.start'))
            ->assertOk()
            ->assertViewIs('teacher.question-bank.manual-upload.start');
    });
});

describe('store questionnaire', function () {
    test('when subject does not uses statements then it show create question', function () {
        $questionnaire = [
            'name' => fake()->name,
            'subject_id' => Subject::whereNot(function () {
                Subject::withStatementsQuestions();
            })->inRandomOrder()->first()->id,
        ];

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->post(route('teacher.question-bank.manual-upload.store-questionnaire'), $questionnaire)
            ->assertRedirect();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.manual-upload.create-question');
    });
    test('when subject uses statements then it show create statement', function () {
        $questionnaire = [
            'name' => fake()->name,
            'subject_id' => Subject::withStatementsQuestions()->inRandomOrder()->first()->id,
        ];

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->post(route('teacher.question-bank.manual-upload.store-questionnaire'), $questionnaire)
            ->assertRedirect();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.manual-upload.create-statement');
    });
});

describe('store question', function () {
    test('when questionnaire is empty', function () {
        $subject = Subject::whereNot(function () {
            Subject::withStatementsQuestions();
        })->inRandomOrder()->first();

        $questionnaire = QuestionnairePrototype::factory()
                            ->forSubject($subject)->hasVersions()->create();

        $question = [
            'name' => fake()->name,
            'description' => fake()->sentence,
            'body' => fake()->text,
            'answer' => fake()->text,
            'explanation' => fake()->text,
            'tags' => Tag::inRandomOrder()->limit(2)->get()->pluck('id')->toArray(),
        ];

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->post(route('teacher.question-bank.manual-upload.store-question', $questionnaire), $question)
            ->assertRedirect();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.manual-upload.create-question');

        expect($questionnaire->latest->questions()->count())->toBe(1);
    });
    test('when statement is created', function () {
        $subject = Subject::withStatementsQuestions()->inRandomOrder()->first();

        $questionnaire = QuestionnairePrototype::factory()
                            ->forSubject($subject)->hasVersions()->create();

        $statement = ManualUploadService::createStatement($questionnaire, fake()->sentence, null, null);

        $question = [
            'name' => fake()->name,
            'description' => fake()->sentence,
            'body' => fake()->text,
            'answer' => fake()->text,
            'explanation' => fake()->text,
            'tags' => Tag::inRandomOrder()->limit(2)->get()->pluck('id')->toArray(),
        ];

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher->user)
            ->post(route('teacher.question-bank.manual-upload.store-question', $questionnaire), $question)
            ->assertRedirect();

        $this->followRedirects($response)
            ->assertViewIs('teacher.question-bank.manual-upload.create-question');

        expect($questionnaire->latest->questions()->count())->toBe(1);
        expect($questionnaire->latest->statements()->count())->toBe(1);
        expect($statement->questions[0]->id)->toBe($questionnaire->latest->questions[0]->id);
    });
});

describe('store statement', function () {
    test('it works');
});

describe('edit question', function () {
    it('shows view');
});

describe('edit statement', function () {
    it('shows view');
});

describe('update question', function () {
    test('when question does not belongs to statement');
    test('when question belongs to statement');
});

describe('update statement', function () {
    test('it works');
});

describe('delete question', function () {
    test('when question does not belongs to statement');
    test('when question belongs to statement');
});

describe('delete statement', function () {
    test('it works');
});

describe('review questionnaire', function () {
    it('when has statements');
    it('when has not statements');
});
