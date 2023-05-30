<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionnairePrototype;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnairePrototypeController extends Controller
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
    public function show(Request $request, QuestionnairePrototype $questionnairePrototype): JsonResponse
    {
        if ($request->with_latest) {
            $questionnairePrototype->load('latest');

            if ($request->with_latest_items_for_edit) {
                $questionnairePrototype->latest->itemsForEdit = $questionnairePrototype->latest->getItemsForEdit(); // @phpstan-ignore-line
            }
        }

        return response()->json($questionnairePrototype);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionnairePrototype $questionnairePrototype): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionnairePrototype $questionnairePrototype): void
    {
        //
    }
}
