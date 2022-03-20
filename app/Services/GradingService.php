<?php

namespace App\Services;

use App\Models\Questionnaire;

/**
 * Class GradingService
 * @package App\Services
 */
class GradingService
{
    private Questionnaire $questionnaire;

    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public function getGrade($score) : int
    {
        switch ($this->questionnaire->subject->name) {
            case 'matematicas':
                return self::matematicas($score);
            case 'lenguaje':
                return self::lenguaje($score);
            case 'historia':
                return self::historia($score);
            case 'fisica':
                return self::ciencias($score);
            case 'quimica':
                return self::ciencias($score);
            case 'biologia':
                return self::ciencias($score);
            case 'tp':
                return self::ciencias($score);
        }
        return 'false';
    }

    private function matematicas(int $score) : int
    {
        return ScoresService::$matematicas[$score];
    }

    private function lenguaje(int $score) : int
    {
        return ScoresService::$lenguaje[$score];
    }

    private function historia(int $score) : int
    {
        return ScoresService::$historia[$score];
    }

    private function ciencias(int $score) : int
    {
        return ScoresService::$ciencias[$score];
    }
}
