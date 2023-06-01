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
        $questions = $questionnaire->questions;

        if ($score === null) {
            $score = 0;
            foreach ($questions as $question) {
                $rand = rand(0, 1);

                $alternative = $question->alternatives()->whereCorrect($rand)->firstOrFail();
                $student->attachAlternative($alternative);

                if ($alternative->correct) {
                    ++$score;
                }
            }

            return $score;
        }

        $correct = $questions->random($score);

        $incorrect = $questions->diff($correct);

        foreach ($correct as $question) {
            $student->attachAlternative($question->alternatives()->whereCorrect(true)->firstOrFail());
        }

        foreach ($incorrect as $question) {
            $student->attachAlternative($question->alternatives()->whereCorrect(false)->firstOrFail());
        }

        return $score;
    }
}
