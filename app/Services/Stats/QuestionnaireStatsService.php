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
        ];

        $this->computeClass = new ComputeQuestionnaireStatsService($this->questionnaire);

        parent::__construct("questionnaire.{$this->questionnaire->id}", $stats);
    }

    public function getAverageScore(): float
    {
        if (!$this->exists('averageScore')) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return round($this->stats['averageScore'], 1);
    }

    public function getAverageScoreInQuestions($questions): float
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
        $this->stats['averageScoreByTag'] = null;

        if (!$this->exists('averageScoreByTag')) {
            $this->setStats('averageScoreByTag', $this->computeClass->averageScoreByTag());
        }

        return $this->stats['averageScoreByTag'];
    }

    public function getTagsOnQuestions(): array
    {
        $this->stats['tagsOnQuestions'] = null;

        if (!$this->exists('tagsOnQuestions')) {
            $this->setStats('tagsOnQuestions', $this->computeClass->tagsOnQuestions());
        }

        return $this->stats['tagsOnQuestions'];
    }
}
