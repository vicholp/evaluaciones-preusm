<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResultsController extends Controller
{
    public function questionnaireGroup(QuestionnaireGroup $questionnaireGroup): View
    {
        $student = Auth::user()?->student;
        $questionnaires = $questionnaireGroup->questionnaires;

        $answeredQuestionnaire = [];

        foreach ($questionnaires as $questionnaire) {
            if ($questionnaire->students()->where('student_id', $student?->id)->exists()) {
                $answeredQuestionnaire[] = $questionnaire->load([
                    'subject',
                    'questions',
                    'questions.tags',
                    'questionnaireGroup'
                ]);
            }
        }

        return view('student.results.questionnaire-group', [
            'questionnaireGroup' => $questionnaireGroup,
            'questionnaires' => $answeredQuestionnaire,
            'student' => $student,
        ]);
    }

    public function questionnaire(Questionnaire $questionnaire): View
    {
        $student = Auth::user()?->student;

        return view('student.results.questionnaire', [
            'questionnaire' => $questionnaire->load([
                'questions',
                'questions.alternatives',
                'questions.tags',
            ]),
            'student' => $student,
        ]);
    }
}
