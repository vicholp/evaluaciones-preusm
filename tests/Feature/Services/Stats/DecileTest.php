<?php

use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function getPercentileScore($scores, $percentile): float
{
    $count = count($scores);
    rsort($scores);

    $index = (int) floor($count * ($percentile / 100));

    return $scores[$index];
}

function getPercentile($scores, $score): int
{
    rsort($scores);

    if ($score > getPercentileScore($scores, 0)) {
        return 1;
    }

    for ($i = 0; $i <= 99; ++$i) {
        if ($score > getPercentileScore($scores, $i)) {
            return $i;
        }
    }

    return 100;
}

function getDecile($scores, $score): int
{
    rsort($scores);

    if ($score > getPercentileScore($scores, 0)) {
        return 1;
    }

    for ($i = 0; $i <= 90; $i += 10) {
        if ($score > getPercentileScore($scores, $i)) {
            return $i / 10;
        }
    }

    return 10;
}

test('decile features', function () {
    $students = Student::factory()->count(20)->create();
    $student = $students[0];
    $questionnaire = Questionnaire::factory()->createWithQuestions(20);

    $scores = [];

    foreach ($students as $student) {
        $scores[] = answerQuestionnaireByStudent($questionnaire, $student, rand(0, 20));
    }

    rsort($scores);

    expect($questionnaire->stats()->getDecileForScore(35))->toBe(1);

    foreach ($scores as $score) {
        if (!rand(0, 5)) {
            continue;
        }

        expect($questionnaire->stats()->getDecileForScore($score))->toBe(getDecile($scores, $score));
    }

    foreach (range(0, 99) as $percentile) {
        if (!rand(0, 5)) {
            continue;
        }

        expect($questionnaire->stats()->getPercentileScore($percentile))->toBe(getPercentileScore($scores, $percentile));
    }

    foreach ($students as $student) {
        if (!rand(0, 5)) {
            continue;
        }
        $score = $student->stats()->getScoreInQuestionnaire($questionnaire);

        expect($student->stats()->getDecileInQuestionnaire($questionnaire))->toBe(getDecile($scores, $score));

        if (getDecile($scores, $score) == 9) {
            expect($student->stats()->isScoreHighInQuestionnaire($questionnaire))->toBeFalse();
            expect($student->stats()->isScoreLowInQuestionnaire($questionnaire))->toBeTrue();
        } elseif (getDecile($scores, $score) == 0) {
            expect($student->stats()->isScoreHighInQuestionnaire($questionnaire))->toBeTrue();
            expect($student->stats()->isScoreLowInQuestionnaire($questionnaire))->toBeFalse();
        }
    }
});
