<?php

namespace App\Http\Controllers\Teacher\Results;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with('user')->get()->sortBy('user.name');

        return view('teacher.results.student.index', [
            'students' => $students,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $questionnaires = $student->questionnaires()->orderBy('created_at')->get();

        return view('teacher.results.student.show', [
            'student' => $student,
            'questionnaires' => $questionnaires,
        ]);
    }
}
