<?php

namespace App\Http\Controllers\Teacher\Results;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Question $question): View
    {
        $students = $question->students()->with('user')->get()->sortBy('user.name');

        return view('teacher.results.question.show', [
            'question' => $question->loadMissing([
                'tags',
                'alternatives',
                'alternatives.students',
            ]),
            'students' => $students,
        ]);
    }

    public function markAsPilot(Question $question): RedirectResponse
    {
        $question->results()->markAsPilot();

        return redirect()->route('teacher.results.questions.show', $question);
    }

    public function unmarkAsPilot(Question $question): RedirectResponse
    {
        $question->results()->unmarkAsPilot();

        return redirect()->route('teacher.results.questions.show', $question);
    }
}
