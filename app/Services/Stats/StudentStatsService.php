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

    public function markAsOutdated(): void
    {
        $this->setStats('outdated', true);
    }

    public function markAsUpdated(): void
    {
        $this->setStats('outdated', false);
    }

    public function isScoreHighInQuestionnaire(Questionnaire $questionnaire): bool
    {
        return $this->getDecileInQuestionnaire($questionnaire) <= 1;
    }

    public function isScoreLowInQuestionnaire(Questionnaire $questionnaire): bool
    {
        return $this->getDecileInQuestionnaire($questionnaire) >= 9;
    }

    public function getDecileInQuestionnaire(Questionnaire $questionnaire): int
    {
        return $questionnaire->stats()->getDecileForScore($this->getScoreInQuestionnaire($questionnaire)); // TODO: Implement in another class
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

        $questionnaire = $this->student->questionnaires->firstWhere('id', $questionnaire->id);

        if (!$questionnaire) {
            return [];
        }

        $questionnaireStudent = $questionnaire->pivot; // @phpstan-ignore-line

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
