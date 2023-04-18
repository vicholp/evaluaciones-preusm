<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;

/**
 * Class QuestionStatsService.
 */
class ComputeQuestionStatsService
{
    public function __construct(
        private Question $question,
    ) {
        //
    }

    public function averageScore(): float
    {
        $sum = 0;

        foreach ($this->question->alternatives()->whereCorrect(true)->get() as $alternative) {
            $sum += $alternative->students()->count();
        }

        if ($sum == 0) {
            return 0;
        }

        return $sum / $this->question->students->count();
    }

    public function averageScoreByDivision(): array
    {
        return [];
    }

    public function facilityIndex(): float
    {
        return 0;
    }

    public function nullIndex(): float
    {
        $count = $this->question->alternatives()->whereName('N/A')->first()->students()->count();

        if ($this->question->students->count() === 0)
            return 0.0;

        return $count / $this->question->students->count();
    }
}
