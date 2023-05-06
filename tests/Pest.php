<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createAndAnswerQuestionnaire($question = 5): Questionnaire
{
    $questionnaire = createQuestionnaire($question);
    $student = Student::factory()->create();

    answerQuestionnaireByStudent($questionnaire, $student);

    return $questionnaire;
}

function createQuestionnaire($question = 5): Questionnaire
{
    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count($question)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }

    return $questionnaire;
}

function addAlternativesToQuestion(Question $question)
{
    Alternative::create(['name' => 'A', 'question_id' => $question->id, 'position' => 1,
        'correct' => false]);
    Alternative::create(['name' => 'B', 'question_id' => $question->id, 'position' => 2,
        'correct' => false]);
    Alternative::create(['name' => 'C', 'question_id' => $question->id, 'position' => 3,
        'correct' => false]);
    Alternative::create(['name' => 'D', 'question_id' => $question->id, 'position' => 4,
        'correct' => false]);
    Alternative::create(['name' => 'E', 'question_id' => $question->id, 'position' => 5,
        'correct' => false]);

    $question->alternatives->random()->update(['correct' => true]);

    Alternative::create(['name' => 'N/A', 'question_id' => $question->id, 'position' => 0,
        'correct' => false]);
}

// function answerQuestionnaireByStudent(Questionnaire $questionnaire, Student $student)
// {
//     foreach ($questionnaire->questions as $question) {
//         $student->attachAlternative($question->alternatives()->inRandomOrder()->first());
//     }
// }

function answerQuestionnaireByStudent(
    Questionnaire $questionnaire,
    Student $student,
    ?int $score = null
): int {
    $questions = $questionnaire->questions;

    if ($score === null) {
        $score = 0;
        foreach ($questions as $question) {
            $rand = rand(0, 1);

            $alternative = $question->alternatives()->whereCorrect($rand)->first();
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
        $student->attachAlternative($question->alternatives()->whereCorrect(true)->first());
    }

    foreach ($incorrect as $question) {
        $student->attachAlternative($question->alternatives()->whereCorrect(false)->first());
    }

    return $score;
}

function answerQuestionByStudent(
    Question $question,
    Student $student,
    ?bool $correct = null
): bool {
    if ($correct === null) {
        $rand = rand(0, 1);

        $alternative = $question->alternatives()->whereCorrect($rand)->first();
        $student->attachAlternative($alternative);

        if ($alternative->correct) {
            return true;
        }

        return false;
    }

    $alternative = $question->alternatives()->whereCorrect($correct)->first();

    $student->attachAlternative($alternative);

    return $correct;
}
