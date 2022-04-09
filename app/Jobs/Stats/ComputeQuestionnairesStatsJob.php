<?php

namespace App\Jobs\Stats;

use App\Jobs\Stats\ComputeQuestionnaireStatsJob;
use App\Models\Questionnaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ComputeQuestionnairesStatsJob implements ShouldQueue
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
        $jobs = [];

        foreach(Questionnaire::lazy() as $questionnaire){
            array_push($jobs, new ComputeQuestionnaireStatsJob($questionnaire));
        }

        $batch = Bus::batch($jobs)->name('Compute Questionnaires Stats')->dispatch();
    }
}
