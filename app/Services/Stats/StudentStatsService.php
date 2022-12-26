<?php

namespace App\Services\Stats;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;
use App\Services\Stats\Compute\ComputeStudentStatsService;

/**
 * Class StudentStatsService
 * @package App\Services
 */
class StudentStatsService extends StatsService
{
    private ComputeStudentStatsService $computeClass;

    public function __construct(
        private Student $student
    ) {
        $stats = [];

        $this->computeClass = new ComputeStudentStatsService($student);

        parent::__construct("student.{$this->student->id}", $stats);
    }

    public function getScoreInQuestionnaire(Questionnaire $questionnaire): int
    {
        $questionnaireStudent = QuestionnaireStudent::whereStudentId($this->student->id)->whereQuestionnaireId($questionnaire->id)->first();

        if (!$questionnaireStudent) {
            return 0;
        }

        if ($questionnaireStudent->score == null) {
            $questionnaireStudent->score = $this->computeClass->scoreInQuestionnaire($questionnaireStudent);
            $questionnaireStudent->save();
        }

        return $questionnaireStudent->score;
    }

    public function getScoreInQuestion(Question $question): int
    {
        $questionStudent = QuestionStudent::whereStudentId($this->student->id)->whereQuestionId($question->id)->first();

        if (!$questionStudent) {
            return 0;
        }

        if ($questionStudent->score == null) {
            $questionStudent->score = $this->computeClass->scoreInQuestion($questionStudent);
            $questionStudent->save();
        }

        return $questionStudent->score;
    }
}
