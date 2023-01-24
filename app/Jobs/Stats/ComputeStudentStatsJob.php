<?php

namespace App\Jobs\Stats;

use App\Models\Student;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeStudentStatsJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $student_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student)
    {
        $this->student_id = $student->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        Student::find($this->student_id)->stats()->computeAll();
    }
}
