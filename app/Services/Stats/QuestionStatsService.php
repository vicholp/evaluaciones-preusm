<?php

namespace App\Services\Stats;

use App\Models\Alternative;
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

    public function markAsOutdated(): void
    {
        $this->setStats('outdated', true);

        $this->question->questionnaire->stats()->markAsOutdated();

        foreach ($this->question->students as $student) {
            $student->stats()->markAsOutdated();
        }
    }

    public function markAsUpdated(): void
    {
        $this->setStats('outdated', false);
    }

    public function clear(): void
    {
        $this->resetStats();

        foreach ($this->question->students as $student) {
            $student->pivot->stats = null; // @phpstan-ignore-line
            $student->pivot->score = null; // @phpstan-ignore-line

            $student->pivot->save(); // @phpstan-ignore-line
        }
    }

    public function all(): void
    {
        foreach ($this->question->students as $student) {
            $student->stats()->computeAllForQuestion($this->question);
        }

        $this->getAverageScore();
        $this->getFacilityIndex();
        $this->getNullIndex();
        $this->getAnswerCount();
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

    public function getAnswerCount(): int
    {
        if (!$this->exists('answerCount')) {
            $this->setStats('answerCount', $this->computeClass->answerCount());
        }

        return $this->stats['answerCount'];
    }

    public function getMarkedCountOnAlternative(Alternative $alternative): int
    {
        if (!$this->exists('markedCountByAlternative')) {
            $this->setStats('markedCountByAlternative', $this->computeClass->markedCountByAlternative());
        }

        return $this->stats['markedCountByAlternative'][$alternative->name];
    }

    public function getMarkedPercentageOnAlternative(Alternative $alternative): float
    {
        $count = $this->getMarkedCountOnAlternative($alternative);
        $total = $this->getAnswerCount();

        if ($total === 0) {
            return 0.0;
        }

        return round(($count / $total) * 100, 2);
    }
}
