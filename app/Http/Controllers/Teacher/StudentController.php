<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teacher.student.index', [
            'students' => Student::all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        return view('teacher.student.show', [
            'student' => $student,
        ]);
    }
}
