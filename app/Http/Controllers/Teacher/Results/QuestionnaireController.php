<?php

namespace App\Http\Controllers\Teacher\Results;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire): View
    {
        return view('teacher.results.questionnaire.show', [
            'questionnaire' => $questionnaire->load([
                'questions',
                'questions.tags',
            ]),
        ]);
    }
}
