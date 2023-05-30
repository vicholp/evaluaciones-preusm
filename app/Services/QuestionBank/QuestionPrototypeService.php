<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;

class QuestionPrototypeService
{
    /**
     * Create a new question and attach a new version to it.
     */
    public function createNewQuestion(): void
    {
        //
    }

    /**
     * Attach a question to questionnaire at the end.
     */
    public function attachToQuestionnaire(
        QuestionPrototype $question,
        QuestionnairePrototype $questionnaire,
    ): void {
        //
    }

    public function createCommentAboutAction(
        QuestionPrototype $question,
        string $content,
    ): void {
        //
    }

    public function restoreToPreviousVersion(
        QuestionPrototype $question,
        QuestionPrototypeVersion $newVersion,
    ): void {
        //
    }

    public function markQuestionAsDisabled(
        QuestionPrototype $question,
    ): void {
        //
    }

    public function markQuestionAsEnabled(
        QuestionPrototype $question,
    ): void {
        //
    }
}
