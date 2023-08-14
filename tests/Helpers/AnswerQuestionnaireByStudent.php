<?php

namespace Tests\Helpers;

use App\Models\Questionnaire;
use App\Models\Student;

class AnswerQuestionnaireByStudent
{
    public static function call(
        Questionnaire $questionnaire,
        Student $student,
        int $score = null
    ): int {
        if ($score === null) {
            $score = fake()->numberBetween(0, $questionnaire->questions->count());
        }
        $questions = $questionnaire->questions;

        $correct = $questions->random($score);
        $incorrect = $questions->diff($correct);

        foreach ($correct as $question) {
            $student->attachAlternative($question->alternatives()->whereCorrect(true)->firstOrFail());

            if ($question->pilot) {
                --$score;
            }
        }

        foreach ($incorrect as $question) {
            $student->attachAlternative($question->alternatives()->whereCorrect(false)->firstOrFail());
        }

        return $score;
    }
}
