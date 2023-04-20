<?php

namespace App\Services\Stats;

use App\Models\Question;
use App\Services\Stats\Compute\ComputeQuestionStatsService;

/**
 * Class QuestionStatsService.
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
            'nullIndex' => null,
        ];

        $this->computeClass = new ComputeQuestionStatsService($this->question);

        parent::__construct($stats, $question);
    }

    public function getAverageScore(): float
    {
        if (!$this->exists('averageScore')) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return round($this->stats['averageScore'], 2);
    }

    public function getFacilityIndex(): float
    {
        if (!$this->exists('facilityIndex')) {
            $this->setStats('facilityIndex', $this->computeClass->facilityIndex());
        }

        return $this->stats['facilityIndex'];
    }

    public function getNullIndex(): float
    {
        if (!$this->exists('nullIndex')) {
            $this->setStats('nullIndex', $this->computeClass->nullIndex());
        }

        return round($this->stats['nullIndex'], 2);
    }
}
