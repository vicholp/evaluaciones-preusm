<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;

/**
 * Class QuestionStatsService
 */
class ComputeQuestionStatsService
{
    public function __construct(
        private Question $question,
    ) {
        //
    }

    public function averageScore(): int
    {
        $sum = 0;

        foreach ($this->question->alternatives()->whereCorrect(true)->get() as $alternative) {
            $sum += $alternative->students()->count();
        }

        return $sum;
    }

    public function averageScoreByDivision(): array
    {
        return [];
    }

    public function facilityIndex(): float
    {
        return 0;
    }
}