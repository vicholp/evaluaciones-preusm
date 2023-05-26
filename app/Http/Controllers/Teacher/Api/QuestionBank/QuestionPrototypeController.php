<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionPrototypeCollection;
use App\Models\QuestionPrototype;
use Illuminate\Http\Request;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuestionPrototypeCollection
    {
        $prototypes = QuestionPrototype::query();

        if ($request->where_subject_id) {
            $prototypes = $prototypes->where('subject_id', $request->where_subject_id);
        }

        if ($request->with_latest) {
            $prototypes = $prototypes->with('latest');
        }

        if ($request->with_tags) {
            $prototypes = $prototypes->with('latest.tags');
        }

        if ($request->with_tags_tag_group) {
            $prototypes = $prototypes->with('latest.tags.tagGroup');
        }

        if ($request->where_tags) {
            $tags = $request->where_tags;

            foreach ($tags as $tag) {
                $prototypes->whereHas('latest.tags', function ($query) use ($tag) {
                    $query->where('tags.id', $tag);
                });
            }
        }

        return new QuestionPrototypeCollection($prototypes->paginate(10));
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
