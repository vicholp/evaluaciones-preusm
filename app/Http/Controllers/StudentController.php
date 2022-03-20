<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(User $user)
    {
        $subjects = Subject::where('name', '!=', 'tercero')->get();
        $actual_period = Period::orderBy('start_date', 'DESC')->first();
        $questionnaire_groups = $actual_period->questionnaireGroups()->orderBy('start_date')->get();

        return view('student.index', [
            'student' => $user->student,
            'subjects' => $subjects,
            'questionnaire_groups' => $questionnaire_groups,
        ]);
    }
}
