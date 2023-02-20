<?php

namespace App\Services\Stats\Compute;

use App\Models\Questionnaire;

/**
 * Class QuestionnaireStatsService.
 */
class ComputeQuestionnaireStatsService
{
    public function __construct(
        private Questionnaire $questionnaire,
    ) {
        //
    }

    public function averageScore(): float
    {
        $sum = 0;
        $students = $this->questionnaire->students;

        if ($students->count() === 0) {
            return 0;
        }

        foreach ($students as $student) {
            $sum += $student->stats()->getScoreInQuestionnaire($this->questionnaire);
        }

        return $sum / $this->questionnaire->students()->count();
    }

    public function sentCount(): int
    {
        return $this->questionnaire->students()->count();
    }

    public function studentsSent(): array
    {
        $students = [];

        foreach ($this->questionnaire->students as $student) {
            $students[$student->id] = true;
        }

        $students = array_keys($students);

        return $students;
    }

    public function averageScoreByDivision(): array
    {
        return [];
    }

    public function tagsOnQuestions(): array
    {
        $tags = [];

        foreach ($this->questionnaire->questions as $question) {
            array_push($tags, ...$question->tags);
        }

        return $tags;
    }
}
