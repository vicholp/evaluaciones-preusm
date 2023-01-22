<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(): View
    {
        $questionnaireGroup = QuestionnaireGroup::orderBy('created_at')->first();

        return view('teacher.index', [
            'questionnaireGroup' => $questionnaireGroup,
        ]);
    }
}
