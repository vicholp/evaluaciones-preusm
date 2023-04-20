<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\Student;

/**
 * Class StudentStatsService.
 */
class ComputeQuestionnaireStudentStatsService
{
    private Questionnaire $questionnaire;
    private Student $student;

    public function __construct(
        private QuestionnaireStudent $questionnaireStudent, // @phpstan-ignore-line
    ) {
        $questionnaireStudent->loadMissing(['questionnaire', 'student']);

        $this->questionnaire = $questionnaireStudent->questionnaire;
        $this->student = $questionnaireStudent->student;
    }

    public function averageScoreByTags(): array
    {
        $tagGroups = $this->questionnaire->stats()->getTagsOnQuestions();

        foreach ($tagGroups as $tagGroupId => $tags) {
            foreach ($tags['tags'] as $tagId => $tag) {
                $questions = Question::find($tag['questions']);

                $tagGroups[$tagGroupId]['tags'][$tagId]['count'] = $questions?->count();
                $tagGroups[$tagGroupId]['tags'][$tagId]['average'] = $this->student->stats()->getAverageScoreInQuestions($questions);
            }
        }

        return $tagGroups;
    }
}
