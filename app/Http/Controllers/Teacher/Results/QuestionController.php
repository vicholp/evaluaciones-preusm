<?php

namespace App\Http\Controllers\Teacher\Results;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Question $question): View
    {
        return view('teacher.results.question.show', [
            'question' => $question->loadMissing([
                'tags',
                'students',
                'students.user',
                'alternatives',
                'alternatives.students',
            ]),
        ]);
    }
}
