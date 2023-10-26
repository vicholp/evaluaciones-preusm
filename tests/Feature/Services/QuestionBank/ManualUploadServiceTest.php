<?php

use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use App\Models\Tag;
use App\Services\QuestionBank\ManualUploadService;

describe('create new questionnaire', function () {
    test('create it', function () {
        $subject = Subject::inRandomOrder()->first();

        $questionnaire = ManualUploadService::createQuestionnaire(
            'name',
            'description',
            $subject
        );

        expect($questionnaire->versions()->count())->toBe(1);
        expect($questionnaire->latest->name)->toBe('name');
        expect($questionnaire->latest->description)->toBe('description');
    });
});

describe('create statement', function () {
    test('when questionnaire is empty attach it to the questionnaire', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();

        $body = fake()->text();

        $statement = ManualUploadService::createStatement(
            $questionnaire,
            $body,
            fake()->name,
            fake()->sentence,
        );

        expect($statement->body)->toBe($body);
        expect($questionnaire->latest->statements[0]->body)->toBe($body);
        expect($questionnaire->latest->statements[0]->pivot->position)->toBe(1);
    });
    test('when questionnaire has statements and questions attach it to the end', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();

        $statement = ManualUploadService::createStatement(
            $questionnaire,
            fake()->text(),
            fake()->name,
            fake()->sentence,
        );

        ManualUploadService::createQuestion(
            $questionnaire,
            fake()->name,
            fake()->sentence,
            fake()->text(),
            fake()->text(),
            fake()->text(),
            Tag::inRandomOrder()->limit(2)->get(),
        );

        $statement = ManualUploadService::createStatement(
            $questionnaire,
            'text',
            fake()->name,
            fake()->sentence,
        );

        expect($statement->body)->toBe('text');
        expect($questionnaire->latest->statements[1]->body)->toBe('text');
        expect($questionnaire->latest->statements[1]->pivot->position)->toBe(3);
    });
});

describe('create question', function () {
    test('when question does not belongs to statement', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $tags = Tag::inRandomOrder()->limit(2)->get();

        $question = ManualUploadService::createQuestion(
            $questionnaire,
            'name',
            'description',
            'body',
            'answer',
            'solution',
            $tags,
        );

        expect($questionnaire->latest->questions[0]->id)->toBe($question->id);
    });
    test('when question belongs to statement', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();
        $tags = Tag::inRandomOrder()->limit(2)->get();

        $statement = ManualUploadService::createStatement(
            $questionnaire,
            fake()->text(),
            fake()->name,
            fake()->sentence,
        );

        $question = ManualUploadService::createQuestion(
            $questionnaire,
            'name',
            'description',
            'body',
            'answer',
            'solution',
            $tags,
        );

        expect($questionnaire->latest->questions[0]->id)->toBe($question->id);
        expect($statement->questions[0]->id)->toBe($question->parent->id);
    });
    test('when there are many questions and statements', function () {
        $questionnaire = QuestionnairePrototype::factory()->hasVersions()->create();

        for ($i = 0; $i < 3; ++$i) {
            ManualUploadService::createStatement(
                $questionnaire,
                fake()->text(),
                fake()->name,
                fake()->sentence,
            );

            ManualUploadService::createQuestion(
                $questionnaire,
                fake()->name,
                fake()->sentence,
                fake()->text(),
                fake()->text(),
                fake()->text(),
                Tag::inRandomOrder()->limit(2)->get(),
            );
        }

        $question = ManualUploadService::createQuestion(
            $questionnaire,
            'name',
            'description',
            'body',
            'answer',
            'solution',
            Tag::inRandomOrder()->limit(2)->get(),
        );

        expect($questionnaire->latest->questions[3]->id)->toBe($question->id);
        expect($questionnaire->latest->questions[3]->pivot->position)->toBe(7);
        expect($questionnaire->latest->statements[2]->pivot->position)->toBe(5);
    });
});
