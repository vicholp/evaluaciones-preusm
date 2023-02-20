<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireGroup;
use Illuminate\View\View;

class QuestionnaireGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teacher.questionnaire-group.index', [
            'questionnaireGroups' => QuestionnaireGroup::all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionnaireGroup $questionnaireGroup): View
    {
        return view('teacher.questionnaire-group.show', [
            'questionnaireGroup' => $questionnaireGroup,
        ]);
    }
}
