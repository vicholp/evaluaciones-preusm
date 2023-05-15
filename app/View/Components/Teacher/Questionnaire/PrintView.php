<?php

namespace App\View\Components\Teacher\Questionnaire;

use App\Models\QuestionnairePrototype;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PrintView extends Component
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

        $view = '';

        if ($name == 'matematicas 1' || $name == 'matematicas 2') {
            $view = '<x-teacher.instructions-questionnaire.matematicas />';
        }

        if ($name == 'ciencias quimica' || $name == 'ciencias fisica' || $name == 'ciencias biologia') {
            $view = '<x-teacher.instructions-questionnaire.ciencias />';
        }

        return $view;
    }
}
