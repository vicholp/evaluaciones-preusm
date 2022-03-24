<?php

namespace App\Jobs;

use App\Models\Questionnaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ComputeQuestionnairesStatsJob implements ShouldQueue, ShouldBeUnique
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
        $questionnaires = Questionnaire::get();

        foreach($questionnaires as $questionnaire){
            Cache::add("stats.questionnaire.{$questionnaire->id}", $questionnaire->stats()->computeAll(), 25920000);
        }
    }
}
