<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Questionnaire;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('student.index');
    }

    public function get(Request $request): RedirectResponse
    {
        $request->validate([
            'rut' => 'required|string|min:10|max:10',
        ]);

        $rut = Str::before($request->rut, '-');
        $rut_dv = Str::after($request->rut, '-');

        $user = User::whereRut($rut)->first();
        if ($user === null) {
            return back()->withInput($request->all())->withErrors('El rut ingresado no existe');
        }

        return redirect()->route('students.index', $user);
    }

    public function show(User $user): View
    {
        $subjects = Subject::where('name', '!=', 'tercero')->get();
        $actual_period = Period::orderBy('start_date', 'DESC')->firstOrFail();
        $questionnaire_groups = $actual_period->questionnaireGroups()->orderBy('start_date', 'DESC')->get();

        return view('student.show', [
            'student' => $user->student,
            'subjects' => $subjects,
            'questionnaire_groups' => $questionnaire_groups,
        ]);
    }

    public function questionnaire(User $user, Questionnaire $questionnaire): View
    {
        return view('student.questionnaire', ['student' => $user->student, 'questionnaire' => $questionnaire]);
    }
}
