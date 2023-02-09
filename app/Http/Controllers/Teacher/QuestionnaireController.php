<?php

namespace App\Http\Controllers\Teacher;

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
        return view('teacher.questionnaire.show', [
            'questionnaire' => $questionnaire,
        ]);
    }
}
