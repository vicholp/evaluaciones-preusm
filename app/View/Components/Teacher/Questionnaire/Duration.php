<?php

namespace App\View\Components\Teacher\Questionnaire;

use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Duration extends Component
{
    private Subject $subject;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private QuestionnairePrototype $questionnaire
    ) {
        $this->subject = $this->questionnaire->subject;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        $name = $this->subject->name;

        $duration = '';

        if ($name == 'matematicas 1' || $name == 'matematicas 2') {
            $duration = '2 horas y 20 minutos';
        }

        if ($name == 'historia') {
            $duration = '2 horas';
        }

        if ($name == 'ciencias quimica' || $name == 'ciencias fisica' || $name == 'ciencias biologia') {
            $duration = '2 horas y 40 minutos';
        }

        return $duration;
    }
}
