<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\StatementPrototype;
use App\Models\Subject;
use App\Models\Tag;
use Illuminate\Support\Collection;

/**
 * Manually upload the questions and statements to the question bank.
 *
 * Uploads are done one by one, and in the same order as they appear in the questionnaire.
 *
 * It is intended to be used by the teachers when there is an existing questionnaire
 * that they want to upload to the question bank.
 */
class ManualUploadService
{
    public static function createQuestionnaire(
        ?string $name,
        ?string $description,
        Subject $subject,
    ): QuestionnairePrototype {
        return QuestionnairePrototypeService::create(
            $name,
            $description,
            $subject
        );
    }

    public static function createStatement(
        QuestionnairePrototype $questionnaire,
        string $body,
        ?string $name,
        ?string $description,
    ): StatementPrototype {
        $statement = StatementPrototypeService::create($questionnaire->subject, $name, $description, $body);

        $service = new QuestionnairePrototypeService($questionnaire);

        $service->attachStatement(
            $statement
        );

        return $statement;
    }

    /**
     * @param Collection<int, Tag> $tags
     */
    public static function createQuestion(
        QuestionnairePrototype $questionnaire,
        ?string $name,
        ?string $description,
        string $body,
        string $answer,
        ?string $solution,
        ?Collection $tags,
    ): QuestionPrototypeVersion {
        $question = QuestionPrototypeService::create(
            $questionnaire->subject,
            $name,
            $description,
            $body,
            $answer,
            $solution,
            $tags,
        );

        $service = new QuestionnairePrototypeService($questionnaire);

        $service->attachQuestion(
            $question
        );

        if ($service->hasStatements()) {
            $question->parent->statement()->associate($service->getLastStatement());
            $question->parent->save();
        }

        return $question;
    }
}
