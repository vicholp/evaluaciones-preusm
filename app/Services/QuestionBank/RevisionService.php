<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionnairePrototypeVersion;

class RevisionService
{
    private QuestionnairePrototypeVersion $latest;

    public function __construct(
        private QuestionnairePrototype $questionnairePrototype,
    ) {
        $this->latest = $this->questionnairePrototype->latest; // @phpstan-ignore-line
    }

    public function startRevision(): array
    {
        return [
            'questionnairePrototypeVersion' => $this->latest,
        ];
    }

    public function questionRevision(int $position): array
    {
        $questionVersion = $this->latest->questions()->wherePivot('position', $position)->first();

        $questionsCount = $this->latest->questions()->count();

        return [
            'currentQuestion' => $questionVersion,
            'nextQuestion' => $position >= $questionsCount ? null : $position + 1,
            'previousQuestion' => $position <= 1 ? null : $position - 1,
            'position' => $position,
            'questionsCount' => $questionsCount,
            'questionnaire' => $this->latest,
        ];
    }

    public function updateQuestionnaire(
        string $name,
        string $description,
    ): void {
        //
    }

    public function updateQuestion(
        int $position,
        string $name,
        string $description,
        string $body,
        string $answer,
        string $solution,
        array $tags
    ): void {
        //
    }
}
