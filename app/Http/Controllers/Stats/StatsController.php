<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireGroup;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Period;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $periods = Period::get();
        return view('stats.index', ['periods' => $periods]);
    }

    public function questionnaireGroup(QuestionnaireGroup $questionnaireGroup)
    {
        $questionnaires = $questionnaireGroup->questionnaires;

        return view('stats.questionnaireGroup', ['questionnaires' => $questionnaires]);
    }

    public function questionnaire(Questionnaire $questionnaire)
    {
        return view('stats.questionnaire', ['questionnaire' => $questionnaire]);
    }

    public function question(Question $question)
    {
        return view('stats.question', ['question' => $question]);
    }
}
