<?php

namespace App\Jobs\Services\Stats;

use App\Models\Question;
use App\Models\Student;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeStudentStatsForQuestionJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $student_id;
    private int $question_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student, Question $question)
    {
        $this->student_id = $student->id;
        $this->question_id = $question->id;
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
        $question = Question::findOrFail($this->question_id);

        $student->stats()->computeAllForQuestion($question);
    }
}
