<?php

namespace App\Jobs;

use App\Jobs\Stats\ComputeQuestionnairesStatsJob;
use App\Jobs\Stats\ComputeQuestionsStatsJob;
use App\Jobs\Stats\ComputeStudentsStatsJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ComputeAllStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Bus::chain([
            new ComputeStudentsStatsJob,
            new ComputeQuestionsStatsJob,
            new ComputeQuestionnairesStatsJob,
        ])->dispatch();
    }
}
