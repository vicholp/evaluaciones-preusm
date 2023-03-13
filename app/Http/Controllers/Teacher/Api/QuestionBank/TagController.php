<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $tags = Tag::query();

        if ($request->where_subject_id) {
            $tags = $tags->where('subject_id', $request->where_subject_id);
        }

        if ($request->or_where_subject_id_null) {
            $tags = $tags->orWhereNull('subject_id');
        }

        if ($request->has_question_prototypes_latest) {
            $tags = $tags->whereHas('questionPrototypeVersions');
        }

        if ($request->with_tag_group) {
            $tags = $tags->with('tagGroup');
        }

        if ($request->by_tag_group) {
            $tagGroups = TagGroup::query();

            $tagGroups = $tagGroups->get();

            foreach ($tagGroups as $tagGroup) {
                $tagGroup->tags()->$tags->get();
            }

            return response()->json($tagGroups);
        }

        return response()->json($tags->get());
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
     *
     * @param int $id
     */
    public function show($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id): void
    {
        //
    }
}
