<?php

namespace App\Services\Stats;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StatsService.
 */
abstract class StatsService
{
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
        $fromCache = $this->model->stats ?? [];

        if ($fromCache) {
            $this->stats = json_decode($fromCache, true);
        }
    }

    public function isUpdated(): bool
    {
        if (isset($this->stats['outdated'])) {
            return !$this->stats['outdated'];
        }

        return true;
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
