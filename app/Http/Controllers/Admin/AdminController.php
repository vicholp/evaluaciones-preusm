<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        $questionnaireGroups = QuestionnaireGroup::all();
        $periods = Period::all();
        $questionnaires = Questionnaire::all();

        return view('admin.index', [
            'users' => $users,
            'questionnaireGroups' => $questionnaireGroups,
            'periods' => $periods,
            'questionnaires' => $questionnaires,
        ]);
    }
}
