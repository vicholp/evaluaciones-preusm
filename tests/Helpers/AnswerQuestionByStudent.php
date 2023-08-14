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
            $correct = fake()->boolean();
        }
        $alternative = $question->alternatives()->whereCorrect($correct)->firstOrFail();

        $student->attachAlternative($alternative);

        return $correct;
    }
}
