<?php

namespace App\Services\Stats;

use App\Models\QuestionnaireGroup;
use App\Services\Stats\Compute\ComputeQuestionnaireGroupStatsService;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionnaireGroupStatsService
 * @package App\Services
 */
class QuestionnaireGroupStatsService extends StatsService
{
    private ComputeQuestionnaireGroupStatsService $computeClass;

    public function __construct(
        private QuestionnaireGroup $questionnaireGroup,
    ) {
        $this->computeClass = new ComputeQuestionnaireGroupStatsService($this->questionnaireGroup);
        $this->getStats();
    }

    private array $stats = [
        'sentCount' => null,
        'studentsSentCount' => null,
        'tagsOnQuestions' => null,
    ];

    private function getStats(): void
    {
        $fromCache = Cache::store('database')->get("stats.questionnaireGroup.{$this->questionnaireGroup->id}", false);

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    private function setStats(string $key, string|bool|int|float|array $value): void
    {
        $this->stats[$key] = $value;

        Cache::store('database')->put("stats.questionnaireGroup.{$this->questionnaireGroup->id}", json_encode($this->stats), self::cache_time);
    }

    public function getSentCount(): int
    {
        if (!$this->stats['sentCount']) {
            $this->setStats('sentCount', $this->computeClass->sentCount());
        }

        return $this->stats['sentCount'];
    }

    public function getStudentsSentCount(): int
    {
        if (!$this->stats['studentsSentCount']) {
            $this->setStats('studentsSentCount', $this->computeClass->studentsSentCount());
        }

        return $this->stats['studentsSentCount'];
    }
}
