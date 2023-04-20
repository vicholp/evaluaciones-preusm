<?php

namespace App\Jobs\Services\Stats;

use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ComputeStudentStatsForQuestionnaireJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $student_id;
    private int $questionnaire_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student, Questionnaire $questionnaire)
    {
        $this->student_id = $student->id;
        $this->questionnaire_id = $questionnaire->id;
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

        $student = Student::findOrFail($this->student_id);
        $questionnaire = Questionnaire::findOrFail($this->questionnaire_id);

        $jobs = [];

        foreach ($questionnaire->questions as $question) {
            array_push($jobs, new ComputeStudentStatsForQuestionJob($student, $question));
        }

        Bus::batch($jobs)
            ->name('Compute students stats for questionnaire' . $questionnaire->id)
            ->then(function () use ($student, $questionnaire) {
                $student->stats()->computeAllForQuestionnaire($questionnaire);
            })
            ->dispatch();
    }
}
