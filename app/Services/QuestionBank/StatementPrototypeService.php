<?php

namespace App\Services\QuestionBank;

use App\Models\StatementPrototype;
use App\Models\Subject;

class StatementPrototypeService
{
    public static function create(
        Subject $subject,
        ?string $name,
        ?string $description,
        string $body,
    ): StatementPrototype {
        return StatementPrototype::create([
            'name' => $name,
            'description' => $description,
            'subject_id' => $subject->id,
            'body' => $body,
        ]);
    }

    public static function update(
        StatementPrototype $statement,
        string $name = null,
        string $description = null,
        string $body = null,
    ): StatementPrototype {
        if ($name !== null) {
            $statement->name = $name;
        }

        if ($description !== null) {
            $statement->description = $description;
        }

        if ($body !== null) {
            $statement->body = $body;
        }

        $statement->save();

        return $statement;
    }
}
