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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, QuestionnairePrototype $questionnairePrototype): JsonResponse
    {
        if ($request->with_latest) {
            $questionnairePrototype->load('latest');

            if ($request->with_latest_items_for_edit) {
                $questionnairePrototype->latest->itemsForEdit = $questionnairePrototype->latest->getItemsForEdit();
            }
        }
        return response()->json($questionnairePrototype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnairePrototype $questionnairePrototype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnairePrototype  $questionnairePrototype
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnairePrototype $questionnairePrototype)
    {
        //
    }
}
