<?php

namespace App\Services\Stats;

use App\Jobs\ComputeQuestionsStatsJob;
use App\Models\Division;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionStatsService
 * @package App\Services
 */
class QuestionStatsService
{
    private Question $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    public function average($students) : float
    {
        $sum = 0;
        $n_students = 0;

        foreach ($students as $student) {
            //if(! $student->sentQuestionnaire($this->question->questionnaire)) continue;

            $sum += $student->correctAnswer($this->question);
            $n_students += 1;
        }

        if($n_students === 0) return 0;

        return $sum/$n_students;
    }

    public function byDivision() : array
    {
        $question = $this->question;

        return Cache::remember("stats.question.{$question->id}.byDivision", 25920000, function() {
            return $this->computeByDivision();
        });
    }

    public function computeByDivision() : array
    {
        $question = $this->question;

        $divisions = Division::wherePeriodId($question->questionnaire->period->id)
            ->where(function ($query) use ($question){
                $query->whereSubjectId($question->questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $stats = [];

        foreach($divisions as $division) {
            $stats[$division->name] = round($question->stats()->average($division->students) * 100, 0).'%';
        }

        return $stats;
    }
}
