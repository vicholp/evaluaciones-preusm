<?php

namespace App\Services\Stats\Compute;

use App\Models\QuestionnaireGroup;

/**
 * Class ComputeQuestionnaireGroupStatsService
 * @package App\Services
 */
class ComputeQuestionnaireGroupStatsService
{
    public function __construct(
        private QuestionnaireGroup $questionnaireGroup,
    ) {
        //
    }

    public function sentCount(): int
    {
        $sum = 0;
        foreach ($this->questionnaireGroup->questionnaires as $questionnaire) {
            $sum += $questionnaire->stats()->getSentCount();
        }

        return $sum;
    }

    public function studentsSentCount(): int
    {
        $students = [];

        return 0;
    }
}
