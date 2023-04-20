<?php

namespace App\Services\Stats;

use App\Models\QuestionnaireStudent;
use App\Services\Stats\Compute\ComputeQuestionnaireStudentStatsService;

/**
 * Class StudentStatsService.
 */
class QuestionnaireStudentStatsService extends StatsService
{
    private ComputeQuestionnaireStudentStatsService $computeClass;

    public function __construct(
        private QuestionnaireStudent $questionnaireStudent // @phpstan-ignore-line
    ) {
        $stats = [
            'averageScoreByTags' => null,
        ];

        $this->computeClass = new ComputeQuestionnaireStudentStatsService($questionnaireStudent);

        parent::__construct($stats, $questionnaireStudent);
    }

    public function getAverageScoreByTags(): array
    {
        if (!$this->stats['averageScoreByTags']) {
            $this->setStats('averageScoreByTags', $this->computeClass->averageScoreByTags());
        }

        return $this->stats['averageScoreByTags'];
    }
}
