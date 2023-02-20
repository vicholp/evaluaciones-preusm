<?php

namespace App\Services\Grading;

use App\Models\Questionnaire;

/**
 * Class GradingService.
 */
class GradingService
{
    private Questionnaire $questionnaire;

    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public function getGrade(int $score): int
    {
        $max_score = $this->gradableQuestions();

        if (!$max_score) {
            return 0;
        }
        if ($score < 0) {
            return -1;
        }

        $subject_name = $this->questionnaire->subject->name;

        if ($subject_name === 'matematicas') {
            return self::matematicas($score, $max_score);
        } elseif ($subject_name === 'lenguaje') {
            return self::lenguaje($score, $max_score);
        } elseif ($subject_name === 'fisica') {
            return self::ciencias($score, $max_score);
        } elseif ($subject_name === 'quimica') {
            return self::ciencias($score, $max_score);
        } elseif ($subject_name === 'biologia') {
            return self::ciencias($score, $max_score);
        } elseif ($subject_name === 'tp') {
            return self::ciencias($score, $max_score);
        } elseif ($subject_name === 'historia') {
            return self::historia($score, $max_score);
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

    private function matematicas(int $score, int $max_score): int
    {
        return PaesGradingService::$matematicas[round($score * 65 / $max_score)];
    }

    private function lenguaje(int $score, int $max_score): int
    {
        return PaesGradingService::$lenguaje[round($score * 65 / $max_score)];
    }

    private function historia(int $score, int $max_score): int
    {
        return PaesGradingService::$historia[round($score * 65 / $max_score)];
    }

    private function ciencias(int $score, int $max_score): int
    {
        return PaesGradingService::$ciencias[round($score * 80 / $max_score)];
    }
}
