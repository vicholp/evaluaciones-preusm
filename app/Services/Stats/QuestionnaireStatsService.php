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
        ];

        $this->computeClass = new ComputeQuestionnaireStatsService($this->questionnaire);

        parent::__construct("questionnaire.{$this->questionnaire->id}", $stats);
    }

    public function getAverageScore(): float
    {
        if (!$this->stats['averageScore']) {
            $this->setStats('averageScore', $this->computeClass->averageScore());
        }

        return round($this->stats['averageScore'], 1);
    }

    public function getAverageScoreByDivision(): array
    {
        if (!$this->stats['averageScoreByDivision']) {
            $this->setStats('averageScoreByDivision', $this->computeClass->averageScoreByDivision());
        }

        return $this->stats['averageScoreByDivision'];
    }

    public function getSentCount(): int
    {
        if (!$this->stats['sentCount']) {
            $this->setStats('sentCount', $this->computeClass->sentCount());
        }

        return $this->stats['sentCount'];
    }

    public function getStudentsSent(): array
    {
        if (!$this->stats['studentsSent']) {
            $this->setStats('studentsSent', $this->computeClass->studentsSent());
        }

        return $this->stats['studentsSent'];
    }

    public function getStudentsSentCount(): int
    {
        if (!$this->stats['studentsSentCount']) {
            $this->setStats('studentsSentCount', count($this->getStudentsSent()));
        }

        return $this->stats['studentsSentCount'];
    }

    public function getTagsOnQuestions(): array
    {
        if (!$this->stats['tagsOnQuestions']) {
            $this->setStats('tagsOnQuestions', $this->computeClass->tagsOnQuestions());
        }

        return $this->stats['tagsOnQuestions'];
    }
}
