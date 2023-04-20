<?php

namespace App\Services\Stats;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;
use App\Services\Stats\Compute\ComputeStudentStatsService;

/**
 * Class StudentStatsService.
 */
class StudentStatsService extends StatsService
{
    private ComputeStudentStatsService $computeClass;

    public function __construct(
        private Student $student
    ) {
        $stats = [];

        $this->computeClass = new ComputeStudentStatsService($student);

        parent::__construct($stats, $student);
    }

    public function computeAllForQuestion(Question $question): void
    {
        $this->getScoreInQuestion($question);
    }

    public function computeAllForQuestionnaire(Questionnaire $questionnaire): void
    {
        $this->getScoreInQuestionnaire($questionnaire);
    }

    public function getScoreInQuestionnaire(Questionnaire $questionnaire): int
    {
        $questionnaireStudent = QuestionnaireStudent::whereStudentId($this->student->id)->whereQuestionnaireId($questionnaire->id)->first();

        if (!$questionnaireStudent) {
            return 0;
        }

        if ($questionnaireStudent->score === null) {
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

        if ($questionStudent->score === null) {
            $questionStudent->score = $this->computeClass->scoreInQuestion($questionStudent);
            $questionStudent->save();
        }

        return $questionStudent->score;
    }

    public function getAverageScoreInQuestions($questions): float // @phpstan-ignore-line
    {
        return round($this->computeClass->averageScoreInQuestions($questions), 2);
    }

    public function getAverageScoreByTagsOnQuestionnaire(Questionnaire $questionnaire): array
    {
        $this->student->loadMissing(['questionnaires']);

        $questionnaireStudent = $this->student->questionnaires->firstWhere('id', $questionnaire->id)->pivot; // @phpstan-ignore-line

        return $questionnaireStudent->stats()->getAverageScoreByTags();
    }

    public function getAlternativeAttachedToQuestion(Question $question): null|Alternative
    {
        $questionStudent = QuestionStudent::whereStudentId($this->student->id)->whereQuestionId($question->id)->first();

        return $questionStudent?->alternative;
    }

    public function getGradeInQuestionnaire(Questionnaire $questionnaire): int
    {
        $score = $this->getScoreInQuestionnaire($questionnaire);

        return $questionnaire->grading()->getGrade($score);
    }
}
