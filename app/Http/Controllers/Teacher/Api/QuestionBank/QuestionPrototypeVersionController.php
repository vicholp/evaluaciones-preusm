<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototypeVersion;
use Illuminate\Http\Request;

class QuestionPrototypeVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionPrototypeVersion $questionPrototypeVersion): QuestionPrototypeVersion
    {
        return $questionPrototypeVersion;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionPrototypeVersion $questionPrototypeVersion): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionPrototypeVersion $questionPrototypeVersion): void
    {
        //
    }
}
