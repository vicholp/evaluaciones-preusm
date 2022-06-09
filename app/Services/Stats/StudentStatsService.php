<?php

namespace App\Services\Stats;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;

/**
 * Class StudentStatsService
 * @package App\Services
 */
class StudentStatsService extends StatsService
{
    private int $student_id;

    public function __construct(Student $student)
    {
        $this->student_id = $student->id;
    }

    public function gradeInQuestionnaire(Questionnaire $questionnaire) : int
    {
        $score = $this->scoreInQuestionnaire($questionnaire);

        if ($score === -1) return 0;

        return $questionnaire->getGrade($score);
    }

    public function correctAnswersInQuestionnaire(Questionnaire $questionnaire) : int
    {
        return Cache::store('database')->remember("stats.student.{$this->student_id}.questionnaire.{$questionnaire->id}.correctAnswers", self::cache_time, function() use ($questionnaire) {
            return $this->computeCorrectAnswersInQuestionnaire($questionnaire);
        });
    }

    public function scoreInQuestionnaire(Questionnaire $questionnaire) : int
    {
        return Cache::store('database')->remember("stats.student.{$this->student_id}.questionnaire.{$questionnaire->id}.score", self::cache_time, function() use ($questionnaire) {
            return $this->computeScoreInQuestionnaire($questionnaire);
        });
    }

    public function sentQuestionnaire(Questionnaire $questionnaire) : bool
    {
        return Cache::store('database')->remember("stats.student.{$this->student_id}.questionnaire.{$questionnaire->id}.sended", self::cache_time, function() use ($questionnaire)  {
            return $this->computeSentQuestionnaire($questionnaire);
        });
    }

    public function correctAnswerToQuestion(Question $question) : bool
    {
        $alternative = $this->answerToQuestion($question);
        if ($alternative === null) return false;

        return $alternative->correct;
    }

    public function scoreInQuestion(Question $question) : int
    {
        return Cache::store('database')->remember("stats.student.{$this->student_id}.question.{$question->id}.score", self::cache_time, function() use ($question) {
            return $this->computeScoreInQuestion($question);
        });
    }

    public function answerToQuestion(Question $question) : ?Alternative
    {
        return Alternative::find(Cache::store('database')->remember("stats.student.{$this->student_id}.question.{$question->id}.answer_id", self::cache_time, function() use ($question)  {
            return $this->computeAnswerToQuestion($question);
        }));
    }

    public function computeAll()
    {
        foreach(Questionnaire::lazy() as $questionnaire) {
            Cache::forget("stats.student.{$this->student_id}.questionnaire.{$questionnaire->id}.sended");

            if(! $this->sentQuestionnaire($questionnaire)) continue;

            foreach($questionnaire->questions()->lazy() as $question) {

                Cache::forget("stats.student.{$this->student_id}.question.{$question->id}.answer_id");
                $this->answerToQuestion($question);
            }

            Cache::forget("stats.student.{$this->student_id}.questionnaire.{$questionnaire->id}.score");
            $this->scoreInQuestionnaire($questionnaire);
        }
    }

    public function computeAnswerToQuestion(Question $question) : int
    {
        $alternatives = $question->alternatives;

        if($alternatives === null) return 0;

        foreach($alternatives as $alternative) {
            $result = $alternative->students->find($this->student_id);
            if($result !== null) return $alternative->id;
        }

        return 0;
    }

    public function computeScoreInQuestion(Question $question) : int
    {
        if ($question->pilot) return 0;

        return $this->correctAnswerToQuestion($question);
    }

    /**
     * return amount of right answers to questions that are not marked as pilot
     */
    public function computeScoreInQuestionnaire(Questionnaire $questionnaire) : int
    {
        if(! $this->sentQuestionnaire($questionnaire)) return -1;

        $grade = 0;

        foreach($questionnaire->questions as $question){
            if ($question->pilot) continue;

            $grade += $this->correctAnswerToQuestion($question);
        }

        return $grade;
    }

    /**
     * return amount of right answers to questions, no matter pilot mark
     */
    public function computeCorrectAnswersInQuestionnaire(Questionnaire $questionnaire) : int
    {
        if(! $this->sentQuestionnaire($questionnaire)) return -1;

        $grade = 0;

        foreach($questionnaire->questions as $question){
            $grade += $this->correctAnswerToQuestion($question);
        }

        return $grade;
    }

    /**
     * return true if student has answers to questionnaire
     */
    public function computeSentQuestionnaire(Questionnaire $questionnaire) : bool
    {
        if($questionnaire->questions === null) return false;

        $student = Student::find($this->student_id);

        if ($student->alternatives()->whereQuestionId($questionnaire->questions[0]->id)->first() !== null) return true;

        return false;
    }
}
