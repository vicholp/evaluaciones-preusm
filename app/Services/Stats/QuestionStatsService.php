<?php

namespace App\Services\Stats;

use App\Jobs\ComputeQuestionsStatsJob;
use App\Jobs\Stats\ComputeQuestionStatsJob;
use App\Models\Division;
use App\Models\Question;
use App\Models\Subject;
use App\Services\Stats\Compute\ComputeQuestionStatsService;
use Illuminate\Support\Facades\Cache;

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
        $this->computeClass = new ComputeQuestionStatsService($this->question);
        $this->getStats();
    }

    private array $stats = [
        'averageScore' => null,
        'averageGrade' => null,
        'averageScoreByTag' => null,
        'averageScoreByTagGroup' => null,
        'averageScoreByDivision' => null,
        'facilityIndex' => null,
    ];

    private function getStats(): void
    {
        $fromCache = Cache::store('database')->get("stats.question.{$this->question->id}", false);

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    private function setStats(string $key, string|bool|int|float|array|null $value): void
    {
        $this->stats[$key] = $value;

        Cache::store('database')->put("stats.question.{$this->question->id}", json_encode($this->stats), self::cache_time);
    }

    public function clearStats(string $key): void
    {
        $this->setStats($key, null);
    }

    public function getAverageScore(): int
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
