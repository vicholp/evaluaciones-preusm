<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('score in questionnaire', function () {
    $student = Student::factory()->create();

    $questionnaire = Questionnaire::factory()->create();
    $questions = Question::factory()->for($questionnaire)->count(15)->create();

    foreach ($questions as $question) {
        addAlternativesToQuestion($question);
    }

    $correct = 0;
    foreach ($questions as $question) {
        $c = random_int(0, 1);
        $correct += $c;

        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($student->stats()->getScoreInQuestionnaire($questionnaire))->toBe($correct);
});
