<?php

namespace App\Services\Stats;

use Cache;

/**
 * Class StatsService
 * @package App\Services
 */
abstract class StatsService
{
    protected const cache_time = 25920000;

    public function __construct(
        protected string $cacheKey,
        protected array $stats,
    ) {
        $this->getStats();
    }

    protected function getStats(): void
    {
        $fromCache = Cache::store('database')->get("stats.{$this->cacheKey}", false);

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    protected function setStats(string $key, string|bool|int|float|array|null $value): void
    {
        $this->stats[$key] = $value;

        Cache::store('database')->put("stats.{$this->cacheKey}", json_encode($this->stats), self::cache_time);
    }

    protected function resetStats(): void
    {
        foreach ($this->stats as $key => $value) {
            $this->stats[$key] = null;
        }

        Cache::store('database')->put("stats.{$this->cacheKey}", json_encode($this->stats), self::cache_time);
    }
}
