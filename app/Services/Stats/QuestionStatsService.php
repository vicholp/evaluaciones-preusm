<?php

namespace App\Services\Stats;

use App\Models\Question;
use App\Services\Stats\Compute\ComputeQuestionStatsService;

/**
 * Class QuestionStatsService
 * @package App\Services
 */
class QuestionStatsService extends StatsService
{
    private ComputeQuestionStatsService $computeClass;

    public function __construct(
        private Question $question
    ) {
        $stats = [
            'averageScore' => null,
            'averageGrade' => null,
            'averageScoreByTag' => null,
            'averageScoreByTagGroup' => null,
            'averageScoreByDivision' => null,
            'facilityIndex' => null,
        ];

        $this->computeClass = new ComputeQuestionStatsService($this->question);

        parent::__construct("question.{$this->question->id}", $stats);
    }

    public function getAverageScore(): float
    {
        if (!$this->stats['averageScore']) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return $this->stats['averageScore'];
    }

    public function getFacilityIndex(): float
    {
        if (!$this->stats['facilityIndex']) {
            $this->setStats('facilityIndex', $this->computeClass->facilityIndex());
        }

        return $this->stats['facilityIndex'];
    }
}
