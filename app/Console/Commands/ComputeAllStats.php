<?php

namespace App\Console\Commands;

use App\Jobs\ComputeAllStatsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ComputeAllStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:compute-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Cache::flush();

        ComputeAllStatsJob::dispatch();

        return 0;
    }
}
