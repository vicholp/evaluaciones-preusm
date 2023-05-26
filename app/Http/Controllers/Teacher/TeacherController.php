<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireGroup;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(): View
    {
        $questionnaireGroup = QuestionnaireGroup::orderBy('created_at', 'DESC')->first();

        return view('teacher.index', [
            'questionnaireGroup' => $questionnaireGroup,
        ]);
    }
}
