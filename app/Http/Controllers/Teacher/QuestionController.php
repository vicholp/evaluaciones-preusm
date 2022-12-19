<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Question $question): View
    {
        return view('teacher.question.show', [
            'question' => $question
        ]);
    }
}
