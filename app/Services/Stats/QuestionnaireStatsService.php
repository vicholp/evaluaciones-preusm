<?php

namespace App\Services\Stats;

use App\Jobs\ComputeQuestionnairesStatsJob;
use App\Jobs\Stats\ComputeQuestionnaireStatsJob;
use App\Models\Division;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Models\Subject;
use App\Services\Stats\Compute\ComputeQuestionnaireStatsService;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionnaireStatsService
 * @package App\Services
 */
class QuestionnaireStatsService extends StatsService
{
    private ComputeQuestionnaireStatsService $computeClass;

    public function __construct(
        private Questionnaire $questionnaire,
    ) {
        $this->computeClass = new ComputeQuestionnaireStatsService($this->questionnaire);
        $this->getStats();
    }

    private array $stats = [
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

    private function getStats(): void
    {
        $fromCache = Cache::store('database')->get("stats.questionnaire.{$this->questionnaire->id}", false);

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    private function setStats(string $key, string|bool|int|float|array|null $value): void
    {
        $this->stats[$key] = $value;

        Cache::store('database')->put("stats.questionnaire.{$this->questionnaire->id}", json_encode($this->stats), self::cache_time);
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
