<?php

namespace Tests\Helpers;

use App\Models\Question;
use App\Models\Student;

class AnswerQuestionByStudent
{
    public static function call(
        Question $question,
        Student $student,
        bool $correct = null
    ): bool {
        if ($correct === null) {
            $rand = rand(0, 1);

            $alternative = $question->alternatives()->whereCorrect($rand)->firstOrFail();
            $student->attachAlternative($alternative);

            if ($alternative->correct) {
                return true;
            }

            return false;
        }

        $alternative = $question->alternatives()->whereCorrect($correct)->firstOrFail();

        $student->attachAlternative($alternative);

        return $correct;
    }
}
