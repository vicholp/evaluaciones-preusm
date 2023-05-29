<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Services\Grading\GradingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('score in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

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
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

    expect($student->stats()->getScoreInQuestionnaire($questionnaire))->toBe(0);
});

test('score in question', function () {
    $student = Student::factory()->create();
    $questions = Question::factory()->count(2)->createWithAlternatives();

    $student->attachAlternative($questions[0]->alternatives()->whereCorrect(true)->first());

    expect($student->stats()->getScoreInQuestion($questions[0]))->toBe(1);

    $student->attachAlternative($questions[1]->alternatives()->whereCorrect(false)->first());

    expect($student->stats()->getScoreInQuestion($questions[1]))->toBe(0);
});

test('score in question not answered', function () {
    $student = Student::factory()->create();
    $question = Question::factory()->createWithAlternatives();

    expect($student->stats()->getScoreInQuestion($question))->toBe(0);
});

test('average score in questions', function () {
    $student = Student::factory()->create();
    $questions = Question::factory()->count(15)->createWithAlternatives();

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
    $question = Question::factory()->createWithAlternatives();

    $alternative = $question->alternatives()->inRandomOrder()->first();

    $student->attachAlternative($alternative);

    expect($student->stats()->getAlternativeAttachedToQuestion($question)->id)->toBe($alternative->id);
});

test('score high in questionnaire', function () {
    $students = Student::factory()->count(5)->create();
    $student = $students[0];
    $otherStudents = $students->slice(1);
    $questionnaire = Questionnaire::factory()->createWithAnswers(15, students: $otherStudents);

    answerQuestionnaireByStudent($questionnaire, $student);

    $student->stats()->isScoreHighInQuestionnaire($questionnaire);
});

test('score low in questionnaire', function () {
    $students = Student::factory()->count(5)->create();
    $student = $students[0];
    $otherStudents = $students->slice(1);
    $questionnaire = Questionnaire::factory()->createWithAnswers(15, students: $otherStudents);

    answerQuestionnaireByStudent($questionnaire, $student);

    $student->stats()->isScoreLowInQuestionnaire($questionnaire);
});

test('average score by tags on questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

    answerQuestionnaireByStudent($questionnaire, $student);

    $student->stats()->getAverageScoreByTagsOnQuestionnaire($questionnaire);
});

test('decile in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

    answerQuestionnaireByStudent($questionnaire, $student);

    $student->stats()->getDecileInQuestionnaire($questionnaire);
});

test('grade in questionnaire', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWithQuestions(15);

    answerQuestionnaireByStudent($questionnaire, $student);

    $score = $student->stats()->getScoreInQuestionnaire($questionnaire);

    $grade = (new GradingService($questionnaire))->getGrade($score);

    expect($student->stats()->getGradeInQuestionnaire($questionnaire))->toBe($grade);
});
