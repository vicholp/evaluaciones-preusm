<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(User $user)
    {
        return view('student.index', ['student' => $user->student]);
    }
}
