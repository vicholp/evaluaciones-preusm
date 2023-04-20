<?php

namespace App\Services\Stats\Compute;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;

/**
 * Class StudentStatsService.
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

    public function scoreByTagsOnQuestionnaire(Questionnaire $questionnaire): array
    {
        $tagGroups = $questionnaire->stats()->getTagsOnQuestions();

        foreach ($tagGroups as $tagGroupId => $tags) {
            foreach ($tags['tags'] as $tagId => $tag) {
                $questions = Question::find($tag['questions']);

                $tagGroups[$tagGroupId]['tags'][$tagId]['count'] = $questions?->count();
                $tagGroups[$tagGroupId]['tags'][$tagId]['average'] = $this->student->stats()->getAverageScoreInQuestions($questions);
            }
        }

        return $tagGroups;
    }

    public function averageScoreInQuestions($questions): float
    {
        $sum = 0;
        $count = 0;

        foreach ($questions as $question) {
            $sum += $this->student->stats()->getScoreInQuestion($question);
            ++$count;
        }

        if ($count === 0) {
            return 0;
        }

        return $sum / $count;
    }

    public function averageScore(): float
    {
        return 0.0;
    }
}
