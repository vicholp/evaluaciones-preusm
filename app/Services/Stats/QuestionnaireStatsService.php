<?php

namespace App\Services\Stats;

use App\Jobs\ComputeQuestionnairesStatsJob;
use App\Models\Division;
use App\Models\Questionnaire;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionnaireStatsService
 * @package App\Services
 */
class QuestionnaireStatsService
{
    private Questionnaire $questionnaire;

    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public static function averageOfQuestions($students, $questions) : float
    {
        $sum = 0;

        foreach($questions as $question){
            $sum += $question->stats()->average($students);
        }

        return $sum/count($questions);
    }

    public function average($students) : float
    {
        $sum = 0;
        $questions = $this->questionnaire->questions;

        foreach($questions as $question){
            $sum += $question->stats()->average($students);
        }

        return $sum/count($questions);
    }

    public function getAll() : array
    {
        $questionnaire = $this->questionnaire;

        return Cache::remember("stats.questionnaire.{$questionnaire->id}", 25920000, function() {
            return $this->computeAll();
        });
    }

    public function computeAll() : array
    {
        $questionnaire = $this->questionnaire;

        $divisions = Division::wherePeriodId($questionnaire->period->id)
            ->where(function ($query) use ($questionnaire){
                $query->whereSubjectId($questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $stats = [];

        $tag_groups = $this->questionnaire->tagsByGroup();

        foreach($tag_groups as $tag_group_name => $tag_group) {
            $stats[$tag_group_name] = [];
            foreach($tag_group as $tag) {
                $stats[$tag_group_name][$tag->name] = [];
                foreach($divisions as $division){
                    $questions = $this->questionnaire->questions()->whereHas('tags', function ($query) use ($tag) {
                        $query->where('name', $tag->name);
                    })->with(['alternatives', 'alternatives.students'])->get();

                    $result = self::averageOfQuestions($division->students, $questions);

                    $stats[$tag_group_name][$tag->name][$division->name] = $result;
                }
            }
        }

        foreach($divisions as $division){
            $stats['averages']['average'][$division->name] = self::averageOfQuestions($division->students, $questionnaire->questions);
        }

        return $stats;
    }
}
