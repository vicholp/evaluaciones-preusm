<?php

namespace App\Http\Controllers\Teacher\Results;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\View\View;

class QuestionnaireStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Questionnaire $questionnaire): View
    {
        $students = Student::with('user')->find($questionnaire->stats()->getStudentsSent());
        $students = $students->sortBy('user.name');

        return view('teacher.results.questionnaire.student.index', [
            'questionnaire' => $questionnaire,
            'students' => $students,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire, Student $student): View
    {
        return view('teacher.results.questionnaire.student.show', [
            'questionnaire' => $questionnaire->load(['questions', 'questions.tags', 'questions.alternatives']),
            'student' => $student,
        ]);
    }
}
