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

        parent::__construct("question.{$this->question->id}", $stats);
    }

    public function getAverageScore(): float
    {
        if (!$this->stats['averageScore']) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return round($this->stats['averageScore'], 2);
    }

    public function getFacilityIndex(): float
    {
        if (!$this->stats['facilityIndex']) {
            $this->setStats('facilityIndex', $this->computeClass->facilityIndex());
        }

        return $this->stats['facilityIndex'];
    }

    public function getNullIndex(): float
    {
        if (!isset($this->stats['nullIndex']) || $this->stats['nullIndex'] == null) {
            $this->setStats('nullIndex', $this->computeClass->nullIndex());
        }

        return round($this->stats['nullIndex'], 2);
    }
}
