<?php

namespace App\Jobs\Stats;

use App\Jobs\Stats\ComputeQuestionStatsJob;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ComputeQuestionsStatsJob implements ShouldQueue
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

        foreach(Question::lazy() as $question){
            array_push($jobs, new ComputeQuestionStatsJob($question));
        }

        $batch = Bus::batch($jobs)->name('Compute Question Stats')->dispatch();
    }
}
