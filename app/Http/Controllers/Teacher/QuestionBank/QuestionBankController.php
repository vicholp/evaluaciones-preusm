<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\View\View;

class QuestionBankController extends Controller
{
    public function index(): View
    {
        $questionSubjects = Subject::with('questionPrototype')->forQuestions()->get();
        $questionnaireSubjects = Subject::with('questionPrototype')->forQuestionnairePrototypes()->get();

        return view('teacher.question-bank.index', [
            'questionSubjects' => $questionSubjects,
            'questionnaireSubjects' => $questionnaireSubjects,
        ]);
    }
}
