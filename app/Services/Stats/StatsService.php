<?php

namespace App\Services\Stats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class StatsService.
 */
abstract class StatsService
{
    protected const cache_time = 25920000;

    /**
     * @param Model $model
     */
    public function __construct(
        protected array $stats,
        protected $model,
    ) {
        $this->getStats();
    }

    protected function getStats(): void
    {
        $fromCache = $this->model->stats; // @phpstan-ignore-line

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    protected function setStats(string $key, string|bool|int|float|array|null $value): void
    {
        $this->stats[$key] = $value;

        $this->model->stats = json_encode($this->stats); // @phpstan-ignore-line
        $this->model->save();
    }

    protected function exists(string $key): bool
    {
        return isset($this->stats[$key]) && $this->stats[$key] !== null;
    }

    protected function resetStats(): void
    {
        foreach ($this->stats as $key => $value) {
            $this->stats[$key] = null;
        }

        $this->model->stats = json_encode($this->stats); // @phpstan-ignore-line
        $this->model->save();
    }
}
