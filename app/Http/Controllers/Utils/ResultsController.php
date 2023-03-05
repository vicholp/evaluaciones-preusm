<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\QuestionnaireGroup;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index()
    {
        return view('utils.results.index');
    }

    public function start()
    {
        $subjects = Subject::forQuestionnaires()->get();
        $questionnaireGroups = QuestionnaireGroup::get();

        return view('utils.results.start', [
            'subjects' => $subjects,
            'questionnaireGroups' => $questionnaireGroups
        ]);
    }
}
