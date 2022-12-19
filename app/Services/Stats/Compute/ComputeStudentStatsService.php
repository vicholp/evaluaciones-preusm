<?php

namespace App\Services\Stats\Compute;

use App\Models\Alternative;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;

/**
 * Class StudentStatsService
 */
class ComputeStudentStatsService
{
    public function __construct(
        private Student $student,
    ) {
        //
    }

    public function scoreInQuestion(QuestionStudent $questionStudent): int
    {
        return Alternative::findOrFail($questionStudent->alternative_id)->correct;
    }

    public function scoreInQuestionnaire(QuestionnaireStudent $questionnaireStudent): int
    {
        $questionnaire = Questionnaire::findOrFail($questionnaireStudent->questionnaire_id);
        $score = 0;

        foreach ($questionnaire->questions as $question) {
            $score += $this->student->stats()->getScoreInQuestion($question);
        }

        return $score;
    }

    public function averageScore(): float
    {
        return 0.0;
    }
}
