<?php

namespace App\Services\Stats;

use App\Jobs\ComputeQuestionnairesStatsJob;
use App\Models\Division;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;

/**
 * Class QuestionnaireStatsService
 * @package App\Services
 */
class QuestionnaireStatsService extends StatsService
{
    private Questionnaire $questionnaire;

    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public function averageOfQuestions($students, $questions) : float
    {
        $sum = 0;

        foreach($questions as $question){
            $sum += $question->stats()->computeAverageScore($students);
        }

        return $sum/count($questions);
    }

    public function average($students) : float
    {
        $sum = 0;
        $questions = $this->questionnaire->questions;

        foreach($questions as $question){
            $sum += $question->stats()->computeAverageScore($students);
        }

        return $sum/count($questions);
    }

    public function studentsSent()
    {
        return Student::find(Cache::store('database')->remember("stats.questionnaire.{$this->questionnaire->id}.students.sent", self::cache_time, function() {
            return $this->computeStudentsSent();
        }));
    }

    public function studentsDidntSend()
    {
        return Student::find(Cache::store('database')->remember("stats.questionnaire.{$this->questionnaire->id}.students.didntSend", self::cache_time, function() {
            return $this->computeStudentsDidntSend();
        }));
    }

    public function tagsByGroup()
    {
        return Cache::store('database')->remember("stats.questionnaire.{$this->questionnaire->id}.tags.byGroup", self::cache_time, function() {
            return $this->computeTagsByGroup();
        });
    }

    public function byTagGroupByTagByDivision()
    {
        return Cache::store('database')->remember("stats.questionnaire.{$this->questionnaire->id}.byTagGroupByTagByDivision", self::cache_time, function() {
            return $this->computeByTagGroupByTagByDivision();
        });
    }

    public function computeAll()
    {
        $this->byTagGroupByTagByDivision();
    }

    public function computeStudentsSent() : array
    {
        $questionnaire = $this->questionnaire;

        if($questionnaire->questions === null) return [];

        $listStudents = collect();
        $question = $questionnaire->questions[0];

        foreach($question->alternatives as $alternative){
            foreach($alternative->students as $student){
                $listStudents->push($student->id);
            }
        }

        return $listStudents->toArray();
    }

    public function computeStudentsDidntSend() : array
    {
        $questionnaire = $this->questionnaire;
        $listStudents = collect();
        $divisions = Division::wherePeriodId($questionnaire->period->id)
            ->where(function ($query) use ($questionnaire){
                $query->whereSubjectId($questionnaire->subject->id);
            })
            ->get();

        foreach($divisions as $division){
            foreach($division->students as $student){
                if(! $student->stats()->sentQuestionnaire($this->questionnaire)) {
                    $listStudents->push($student->id);
                }
            }
        }

        return $listStudents->toArray();
    }

    public function computeTagsByGroup()
    {
        $tags = [];

        $questions = $this->questionnaire->questions;

        foreach($questions as $question) {
            $question_tags = $question->tags;
            foreach($question_tags as $tag) {
                $tags[$tag->tagGroup->name][$tag->name] = $tag;
            }
        }

        return array_slice($tags,0,5);
    }

    public function computeByTagGroupByTagByDivision() : array
    {
        $questionnaire = $this->questionnaire;

        $divisions = Division::wherePeriodId($questionnaire->period->id)
            ->where(function ($query) use ($questionnaire){
                $query->whereSubjectId($questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $stats = [];

        $tag_groups = $this->tagsByGroup();

        foreach($tag_groups as $tag_group_name => $tag_group) {
            $stats[$tag_group_name] = [];
            foreach($tag_group as $tag) {
                $stats[$tag_group_name][$tag->name] = [];
                foreach($divisions as $division){
                    $questions = $this->questionnaire->questions()->whereHas('tags', function ($query) use ($tag) {
                        $query->where('name', $tag->name);
                    })->with(['alternatives', 'alternatives.students'])->lazy();

                    $result = round($this->averageOfQuestions($division->students(), $questions)*100, 0).'%';

                    $stats[$tag_group_name][$tag->name][$division->name] = $result;
                }
            }
        }

        foreach($divisions as $division){
            $stats['averages']['average'][$division->name] = round($this->averageOfQuestions($division->students, $questionnaire->questions)*100, 0).'%';
            $stats['averages']['average in points'][$division->name] = $questionnaire->getGrade(round($questionnaire->questions->count()*$this->averageOfQuestions($division->students, $questionnaire->questions)));
        }

        return $stats;
    }
}
