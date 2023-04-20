<?php

namespace App\Http\Controllers\Teacher;

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
        return view('teacher.questionnaire.student.index', [
            'questionnaire' => $questionnaire,
            'students' => Student::with('user')->find($questionnaire->stats()->getStudentsSent()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire, Student $student): View
    {
        $questionsWithStudentRelation = $questionnaire->questions()->with(['students' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->get();

        return view('teacher.questionnaire.student.show', [
            'questionnaire' => $questionnaire,
            'questions' => $questionsWithStudentRelation,
            'student' => $student,
        ]);
    }
}
