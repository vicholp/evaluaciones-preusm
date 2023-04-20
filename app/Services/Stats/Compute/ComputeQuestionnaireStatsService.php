<?php

namespace App\Services\Stats\Compute;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Services\Stats\QuestionnaireStatsService;

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
        $students = $this->questionnaire->loadMissing('students')->students;

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

    public function maxScore(): int
    {
        $max = 0;

        foreach ($this->questionnaire->students as $student) {
            $score = $student->stats()->getScoreInQuestionnaire($this->questionnaire);

            if ($score > $max) {
                $max = $score;
            }
        }

        return $max;
    }

    public function minScore(): int
    {
        $min = (int) INF;

        foreach ($this->questionnaire->students as $student) {
            $score = $student->stats()->getScoreInQuestionnaire($this->questionnaire);

            if ($score < $min) {
                $min = $score;
            }
        }

        return $min;
    }

    public function medianScore(): float
    {
        $scores = [];

        foreach ($this->questionnaire->students as $student) {
            $scores[] = $student->stats()->getScoreInQuestionnaire($this->questionnaire);
        }

        sort($scores);

        $count = count($scores);
        $middle = floor(($count - 1) / 2);

        if ($count % 2) {
            return (float) $scores[$middle];
        }

        return ($scores[$middle] + $scores[$middle + 1]) / 2;
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
            'questions.tags.tagGroup',
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
        $this->questionnaire->loadMissing([
            'questions',
            'questions.tags',
            'questions.tags.tagGroup',
        ]);

        $tagGroups = [];

        foreach ($this->questionnaire->questions as $question) {
            foreach ($question->tags as $tag) {
                $tagGroups[$tag->tagGroup->id]['id'] = $tag->tagGroup->id;
                $tagGroups[$tag->tagGroup->id]['name'] = $tag->tagGroup->name;

                $tagGroups[$tag->tagGroup->id]['tags'][$tag->id]['id'] = $tag->id;
                $tagGroups[$tag->tagGroup->id]['tags'][$tag->id]['name'] = $tag->name;

                $tagGroups[$tag->tagGroup->id]['tags'][$tag->id]['questions'][$question->id] = $question->id;
            }
        }

        foreach ($tagGroups as $tagGroupId => $tags) {
            if (count($tags['tags']) <= 2) {
                unset($tagGroups[$tagGroupId]);

                continue;
            }

            foreach ($tagGroups[$tagGroupId]['tags'] as $tagId => $tag) {
                $tagGroups[$tagGroupId]['tags'][$tagId]['questions'] = array_values($tag['questions']);
            }
        }

        return $tagGroups;
    }
}
