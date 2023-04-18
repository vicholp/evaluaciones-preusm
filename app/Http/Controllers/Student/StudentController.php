<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentLoginRequest;
use App\Models\Period;
use App\Models\User;
use App\Utils\Rut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $period = Period::orderBy('start_date', 'DESC')->firstOrFail();

        $questionnaireGroups = $period->questionnaireGroups()->orderBy('start_date', 'DESC')->get();

        return view('student.index', [
            'student' => Auth::user()?->student,
            'questionnaireGroups' => $questionnaireGroups,
        ]);
    }

    public function login(StudentLoginRequest $request): RedirectResponse
    {
        $rut = Rut::fromString($request->rut);

        $user = User::whereRut($rut->getRut())->first();

        if ($user === null) {
            return redirect()->route('index')->withErrors('El rut ingresado no existe');
        }

        if (!$user->role()->isStudent()) {
            return redirect()->route('index')->withErrors('El rut no corresponde a un estudiante');
        }

        Auth::login($user, remember: true);

        return redirect()->route('student.index', $user);
    }
}
