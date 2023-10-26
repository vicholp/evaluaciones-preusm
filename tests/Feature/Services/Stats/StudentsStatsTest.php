<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Services\Grading\GradingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\AnswerQuestionnaireByStudent;

uses(RefreshDatabase::class);

test('score in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWith();

    $questions = $questionnaire->questions;

    $correct = 0;

    foreach ($questions as $question) {
        $c = random_int(0, 1);

        if (!$question->pilot) {
            $correct += $c;
        }

        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($student->stats()->getScoreInQuestionnaire($questionnaire))->toBe($correct);
});

test('score in questionnaire with no answers', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWith();

    expect($student->stats()->getScoreInQuestionnaire($questionnaire))->toBe(0);
});

test('score in question', function () {
    $student = Student::factory()->create();
    $questions = Question::factory()->count(2)->createWith();

    $student->attachAlternative($questions[0]->alternatives()->whereCorrect(true)->first());

    expect($student->stats()->getScoreInQuestion($questions[0]))->toBe(1);

    $student->attachAlternative($questions[1]->alternatives()->whereCorrect(false)->first());

    expect($student->stats()->getScoreInQuestion($questions[1]))->toBe(0);
});

test('score in question not answered', function () {
    $student = Student::factory()->create();
    $question = Question::factory()->createWith();

    expect($student->stats()->getScoreInQuestion($question))->toBe(0);
});

test('average score in questions', function () {
    $student = Student::factory()->create();
    $questions = Question::factory()->count(15)->createWith();

    $correct = 0;

    foreach ($questions as $question) {
        $c = random_int(0, 1);
        $correct += $c;

        $student->attachAlternative($question->alternatives()->whereCorrect($c)->first());
    }

    expect($student->stats()->getAverageScoreInQuestions($questions))->toBe(round($correct / 15, 2));
});

test('alternative attached to question', function () {
    $student = Student::factory()->create();
    $question = Question::factory()->createWith();

    $alternative = $question->alternatives()->inRandomOrder()->first();

    $student->attachAlternative($alternative);

    expect($student->stats()->getAlternativeAttachedToQuestion($question)->id)->toBe($alternative->id);
});

test('score high in questionnaire', function () {
    $students = Student::factory()->count(5)->create();
    $student = $students[0];
    $otherStudents = $students->slice(1);
    $questionnaire = Questionnaire::factory()->createWithAnswers(15, students: $otherStudents);

    AnswerQuestionnaireByStudent::call($questionnaire, $student);

    $student->stats()->isScoreHighInQuestionnaire($questionnaire);
})->todo();

test('score low in questionnaire', function () {
    $students = Student::factory()->count(5)->create();
    $student = $students[0];
    $otherStudents = $students->slice(1);
    $questionnaire = Questionnaire::factory()->createWithAnswers(15, students: $otherStudents);

    AnswerQuestionnaireByStudent::call($questionnaire, $student);

    $student->stats()->isScoreLowInQuestionnaire($questionnaire);
})->todo();

test('average score by tags on questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWith();

    AnswerQuestionnaireByStudent::call($questionnaire, $student);

    $student->stats()->getAverageScoreByTagsOnQuestionnaire($questionnaire);
})->todo();

test('decile in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWith();

    AnswerQuestionnaireByStudent::call($questionnaire, $student);

    $student->stats()->getDecileInQuestionnaire($questionnaire);
})->todo();

test('grade in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWith();

    AnswerQuestionnaireByStudent::call($questionnaire, $student);

    $score = $student->stats()->getScoreInQuestionnaire($questionnaire);

    $grade = (new GradingService($questionnaire))->getGrade($score);

    expect($student->stats()->getGradeInQuestionnaire($questionnaire))->toBe($grade);
});
