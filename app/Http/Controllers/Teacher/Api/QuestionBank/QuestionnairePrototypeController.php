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
    public function index(Request $request): JsonResponse
    {
        $prototypes = QuestionnairePrototype::query();

        if ($request->order_by) {
            $prototypes = $prototypes->orderBy(
                $request->order_by['column'],
                $request->order_by['direction']
            );
        }

        if ($request->where_subject_id) {
            $prototypes = $prototypes->where('subject_id', $request->where_subject_id);
        }

        if ($request->with_latest) {
            $prototypes = $prototypes->with('latest');
        }

        return response()->json($prototypes->get()->map(function ($prototype) {
            $prototype->name = $prototype->name;

            return $prototype;
        }));
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
}
