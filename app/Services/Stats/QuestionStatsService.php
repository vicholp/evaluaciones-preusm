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
class QuestionStatsService extends StatsService
{
    private int $question_id;

    public function __construct(Question $question)
    {
        $this->question_id = $question->id;
    }

    public function byDivision() : array
    {
        $question_id = $this->question_id;

        return Cache::store('database')->remember("stats.question.{$question_id}.byDivision", self::cache_time, function() {
            return $this->computeByDivision();
        });
    }

    public function computeAll()
    {
        Cache::forget("stats.question.{$this->question_id}.byDivision");
        $this->byDivision();
    }

    public function computeByDivision() : array
    {
        $question = Question::find($this->question_id);

        $divisions = Division::wherePeriodId($question->questionnaire->period->id)
            ->where(function ($query) use ($question){
                $query->whereSubjectId($question->questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $stats = [];

        foreach($divisions as $division) {
            $stats[$division->name] = round($this->computeAverageScore($division->students) * 100, 0).'%';
        }

        return $stats;
    }

    public function computeAverageScore($students) : float
    {
        $question = Question::find($this->question_id);
        $questionnaire = $question->questionnaire;

        $sum = 0;
        $n_students = 0;

        foreach ($students->lazy() as $student) {

            if(! $student->stats()->sentQuestionnaire($questionnaire)) continue;

            $sum += $student->stats()->scoreInQuestion($question);

            $n_students += 1;
        }

        if($n_students === 0) return 0;

        return $sum/$n_students;
    }
}
