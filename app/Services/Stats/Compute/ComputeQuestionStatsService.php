<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;
use App\Models\Student;

/**
 * Class QuestionStatsService.
 */
class ComputeQuestionStatsService
{
    public function __construct(
        private Question $question,
    ) {
        //
    }

    public function averageScore(): float
    {
        $this->question->load('students');

        $sum = 0;

        foreach ($this->question->alternatives()->whereCorrect(true)->get() as $alternative) {
            $sum += $alternative->students()->count();
        }

        if ($sum == 0) {
            return 0;
        }

        return $sum / $this->question->students->count();
    }

    public function discriminationIndex(): float
    {
        $questionnaire = $this->question->questionnaire;
        $students = $this->question->students;

        $scores = collect();

        foreach ($students as $student) {
            $score = $student->stats()->getScoreInQuestionnaire($questionnaire);

            $scores->push([
                'student' => $student->id,
                'score' => $score,
            ]);
        }

        $scores = $scores->sort(function ($a, $b) {
            return $a['score'] <=> $b['score'];
        });

        $studentsCount = $students->count();

        $take = (int) ($studentsCount * 0.27);

        $topStudents = $scores->take(-$take);
        $bottomStudents = $scores->take($take);

        $topStudentsSum = 0;

        foreach ($topStudents as $scores) {
            $student = Student::whereId($scores['student'])->firstOrFail();
            $score = $student->stats()->getScoreInQuestion($this->question);

            $topStudentsSum += $score;
        }

        $bottomStudentsSum = 0;

        foreach ($bottomStudents as $scores) {
            $student = Student::whereId($scores['student'])->firstOrFail();
            $score = $student->stats()->getScoreInQuestion($this->question);

            $bottomStudentsSum += $score;
        }

        return ($topStudentsSum - $bottomStudentsSum) / $take;
    }

    public function averageScoreByDivision(): array
    {
        return [];
    }

    public function facilityIndex(): float
    {
        return 0;
    }

    public function nullIndex(): float
    {
        $count = $this->question->alternatives()->whereName('N/A')->first()?->students()->count();

        if ($this->question->students->count() === 0) {
            return 0.0;
        }

        return $count / $this->question->students->count();
    }

    public function answerCount(): int
    {
        return $this->question->students->count();
    }

    public function markedCountByAlternative(): array
    {
        $alternatives = $this->question->alternatives()->get();

        $markedCountByAlternative = [];

        foreach ($alternatives as $alternative) {
            $markedCountByAlternative[$alternative->name] = $alternative->students()->count();
        }

        return $markedCountByAlternative;
    }
}
