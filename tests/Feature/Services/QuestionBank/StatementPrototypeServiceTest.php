<?php

use App\Models\StatementPrototype;
use App\Models\Subject;
use App\Services\QuestionBank\StatementPrototypeService;

describe('create statement', function () {
    it('works', function () {
        $subject = Subject::inRandomOrder()->first();

        $statement = StatementPrototypeService::create(
            $subject,
            'name',
            'description',
            'body'
        );

        expect($statement->only('subject_id', 'name', 'description', 'body'))->toBe([
            'subject_id' => $subject->id,
            'name' => 'name',
            'description' => 'description',
            'body' => 'body',
        ]);
    });
});

describe('update statement', function () {
    it('works', function () {
        $statement = StatementPrototype::factory()->create();

        $statement = StatementPrototypeService::update(
            $statement,
            'new name',
            'new description',
            'new body'
        );

        expect($statement->only('name', 'description', 'body'))->toBe([
            'name' => 'new name',
            'description' => 'new description',
            'body' => 'new body',
        ]);
    });
});
