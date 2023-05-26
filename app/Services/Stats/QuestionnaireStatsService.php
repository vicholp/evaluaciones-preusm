<?php

namespace App\Services\Stats;

use App\Models\Questionnaire;
use App\Services\Stats\Compute\ComputeQuestionnaireStatsService;

/**
 * Class QuestionnaireStatsService.
 */
class QuestionnaireStatsService extends StatsService
{
    private ComputeQuestionnaireStatsService $computeClass;

    public function __construct(
        private Questionnaire $questionnaire,
    ) {
        $stats = [
            'averageScore' => null,
            'averageGrade' => null,
            'sentCount' => null,
            'studentsSent' => null,
            'studentsSentCount' => null,
            'averageScoreByTag' => null,
            'averageScoreByTagGroup' => null,
            'averageScoreByQuestion' => null,
            'averageScoreByDivision' => null,
            'tagsOnQuestions' => null,
            'maxScore' => null,
            'minScore' => null,
            'medianScore' => null,
        ];

        $this->computeClass = new ComputeQuestionnaireStatsService($this->questionnaire);

        parent::__construct($stats, $questionnaire);
    }


    public function markAsOutdated(): void
    {
        $this->setStats('outdated', true);
    }

    public function markAsUpdated(): void
    {
        $this->setStats('outdated', false);
    }

    public function getAverageScore(): float
    {
        if (!$this->exists('averageScore')) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return round($this->stats['averageScore'], 1);
    }

    public function getAverageGrade(): int
    {
        $score = (int) round($this->getAverageScore(), 0);

        return $this->questionnaire->grading()->getGrade($score);
    }

    public function getAverageScoreInQuestions($questions): float // @phpstan-ignore-line
    {
        return round($this->computeClass->averageScoreInQuestions($questions), 2);
    }

    public function getAverageScoreByDivision(): array
    {
        if (!$this->exists('averageScoreByDivision')) {
            $this->setStats('averageScoreByDivision', $this->computeClass->averageScoreByDivision());
        }

        return $this->stats['averageScoreByDivision'];
    }

    public function getSentCount(): int
    {
        if (!$this->exists('sentCount')) {
            $this->setStats('sentCount', $this->computeClass->sentCount());
        }

        return $this->stats['sentCount'];
    }

    public function getStudentsSent(): array
    {
        if (!$this->exists('studentsSent')) {
            $this->setStats('studentsSent', $this->computeClass->studentsSent());
        }

        return $this->stats['studentsSent'];
    }

    public function getStudentsSentCount(): int
    {
        if (!$this->exists('studentsSentCount')) {
            $this->setStats('studentsSentCount', count($this->getStudentsSent()));
        }

        return $this->stats['studentsSentCount'];
    }

    public function getAverageScoreByTag(): array
    {
        if (!$this->exists('averageScoreByTag')) {
            $this->setStats('averageScoreByTag', $this->computeClass->averageScoreByTag());
        }

        return $this->stats['averageScoreByTag'];
    }

    public function getMaxScore(): int
    {
        if (!$this->exists('maxScore')) {
            $this->setStats('maxScore', $this->computeClass->maxScore());
        }

        return $this->stats['maxScore'];
    }

    public function getMinScore(): int
    {
        if (!$this->exists('minScore')) {
            $this->setStats('minScore', $this->computeClass->minScore());
        }

        return $this->stats['minScore'];
    }

    public function getDecileForScore(int $score): int
    {
        if ($score > $this->getPercentileScore(0)) {
            return 1;
        }

        for ($i = 0; $i <= 90; $i += 10) {
            if ($score > $this->getPercentileScore($i)) {
                return $i / 10;
            }
        }

        return 10;
    }

    public function getPercentileScore(int $percentile): float
    {
        $keyName = $percentile . 'PercentScore';
        if (!$this->exists($keyName)) {
            $this->setStats($keyName, $this->computeClass->percentileScore($percentile));
        }

        return $this->stats[$keyName];
    }

    public function getMedianScore(): float
    {
        if (!$this->exists('medianScore')) {
            $this->setStats('medianScore', $this->computeClass->medianScore());
        }

        return $this->stats['medianScore'];
    }

    public function getTagsOnQuestions(): array
    {
        $this->stats['tagsOnQuestions'] = null;

        if (!$this->exists('tagsOnQuestions')) {
            $this->setStats('tagsOnQuestions', $this->computeClass->tagsOnQuestions());
        }

        return $this->stats['tagsOnQuestions'];
    }

    /**
     * Get the number of students who got each one of the
     * possibles score.
     */
    public function getStudentCountByScore(): array
    {
        return $this->computeClass->studentCountByScore();
    }
}
