<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Services\Stats\QuestionnaireStatsService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class QuestionnaireStatsService.
 */
class ComputeQuestionnaireStatsService
{
    public function __construct(
        private Questionnaire $questionnaire,
    ) {
        //
    }

    public function averageScore(): float
    {
        $sum = 0;
        $students = $this->questionnaire->students;

        if ($students->count() === 0) {
            return 0;
        }

        foreach ($students as $student) {
            $sum += $student->stats()->getScoreInQuestionnaire($this->questionnaire);
        }

        return $sum / $this->questionnaire->students()->count();
    }

    public function sentCount(): int
    {
        return $this->questionnaire->students()->count();
    }

    public function studentsSent(): array
    {
        $students = [];

        foreach ($this->questionnaire->students as $student) {
            $students[$student->id] = true;
        }

        $students = array_keys($students);

        return $students;
    }

    public function averageScoreByDivision(): array
    {
        return [];
    }

    public function averageScoreInQuestions($questions): float // @phpstan-ignore-line
    {
        if ($questions->count() === 0) {
            return 0.0;
        }

        $sum = 0;

        foreach ($questions as $question) {
            $sum += $question->stats()->getAverageScore();
        }

        return $sum / $questions->count();
    }

    public function averageScoreByTag(): array
    {
        $this->questionnaire->loadMissing([
            'questions',
            'questions.tags',
            'questions.tags.tagGroup'
        ]);

        $tagGroups = [];

        foreach ($this->questionnaire->questions as $question) {
            foreach ($question->tags as $tag) {
                $tagGroups[$tag->tagGroup->name][$tag->name][] = $question->id;
            }
        }

        foreach ($tagGroups as $tagGroupId => $tags) {
            foreach ($tags as $tagId => $questions) {
                $tagGroups[$tagGroupId][$tagId] = [
                    'average' => $this->questionnaire->stats()->getAverageScoreInQuestions(Question::find($questions)),
                    'count' => count($questions),
                ];
            }
        }

        foreach ($tagGroups as $tagGroupId => $tags) {
            if (count($tags) === 1) {
                unset($tagGroups[$tagGroupId]);
            }
        }

        return $tagGroups;
    }

    public function tagsOnQuestions(): array
    {
        $tags = [];

        $this->questionnaire->loadMissing([
            'questions',
            'questions.tags'
        ]);

        foreach ($this->questionnaire->questions as $question) {
            foreach ($question->tags as $tag) {
                $tags[$tag->id] = $tag->id;
            }
        }

        $tags = array_values($tags);

        return $tags;
    }
}
