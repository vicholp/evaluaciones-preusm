<?php

namespace App\Services\Grading;

use App\Models\Questionnaire;
use App\Models\Subject;

/**
 * Class GradingService.
 */
class GradingService
{
    private Subject $gradableSubject;

    public function __construct(
        private Questionnaire $questionnaire
    ) {
        $this->gradableSubject = $this->questionnaire->gradableSubject();
    }

    public function getGrade(int $score): int
    {
        $maxScore = $this->gradableQuestions();

        if (!$maxScore) {
            return 0;
        }

        if ($score < 0) {
            return -1;
        }

        if ($score > $maxScore) {
            return 1000;
        }

        $subjectName = $this->gradableSubject->name;

        if ($subjectName === 'matematicas 1' || $subjectName === 'matematicas 2') {
            return self::matematicas($score, $maxScore);
        } elseif ($subjectName === 'lenguaje') {
            return self::lenguaje($score, $maxScore);
        } elseif ($subjectName === 'ciencias fisica') {
            return self::ciencias($score, $maxScore);
        } elseif ($subjectName === 'ciencias quimica') {
            return self::ciencias($score, $maxScore);
        } elseif ($subjectName === 'ciencias biologia') {
            return self::ciencias($score, $maxScore);
        } elseif ($subjectName === 'ciencias TP') {
            return self::ciencias($score, $maxScore);
        } elseif ($subjectName === 'historia') {
            return self::historia($score, $maxScore);
        }

        return 0;
    }

    /**
     * return the amount of questions that arent marked as pilot.
     */
    public function gradableQuestions(): int
    {
        $count = 0;

        foreach ($this->questionnaire->questions as $question) {
            if (!$question->pilot) {
                ++$count;
            }
        }

        return $count;
    }

    /**
     * return the amount of questions that are marked as pilot.
     */
    public function pilotQuestions(): int
    {
        return $this->questionnaire->questions->count() - $this->gradableQuestions();
    }

    private function matematicas(int $score, int $maxScore): int
    {
        return PaesGradingService::$matematicas[round($score * 65 / $maxScore)];
    }

    private function lenguaje(int $score, int $maxScore): int
    {
        return PaesGradingService::$lenguaje[round($score * 65 / $maxScore)];
    }

    private function historia(int $score, int $maxScore): int
    {
        return PaesGradingService::$historia[round($score * 65 / $maxScore)];
    }

    private function ciencias(int $score, int $maxScore): int
    {
        return PaesGradingService::$ciencias[round($score * 80 / $maxScore)];
    }
}
