<?php

namespace App\Http\Controllers\Teacher\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\View\View;

class QuestionBankController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::with('questionPrototype')->forQuestions()->get();

        return view('teacher.question-bank.index', [
            'subjects' => $subjects,
        ]);
    }
}
