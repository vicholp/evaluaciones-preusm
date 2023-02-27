<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use Illuminate\Http\Request;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): string
    {
        $prototypes = QuestionPrototype::query();

        if ($request->subject_id) {
            $prototypes = $prototypes->where('subject_id', $request->subject_id);
        }

        if ($request->tags) {
            $tags = $request->tags;

            $prototypes = $prototypes->whereHas('versions', function ($query) use ($tags) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->where('tags.id', $tags);
                });
            });
        }

        if ($request->with_latest) {
            $prototypes = $prototypes->with('latest');
        }

        if ($request->with_tags) {
            $prototypes = $prototypes->with('latest.tags');
        }

        return $prototypes->limit(15)->get()->toJson();
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
    public function show(QuestionPrototype $questionPrototype): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionPrototype $questionPrototype): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionPrototype $questionPrototype): void
    {
        //
    }
}
