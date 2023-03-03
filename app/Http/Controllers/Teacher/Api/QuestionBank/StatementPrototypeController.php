<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatementPrototypeCollection;
use App\Models\QuestionPrototype;
use App\Models\StatementPrototype;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatementPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prototypes = StatementPrototype::query();

        if ($request->with_questions) {
            $prototypes = $prototypes->with('questions');

            if ($request->with_question_latest) {
                $prototypes = $prototypes->with('questions.latest');
            }

            if ($request->with_question_tags) {
                $prototypes = $prototypes->with('questions.latest.tags');
            }

            if ($request->where_question_tags) {
                $tags = $request->where_question_tags;

                // this get the prototype questions that have all the tags
                $prototypes = $prototypes->with(['questions' => function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->whereHas('latest.tags', function ($query) use ($tag) {
                            $query->where('tags.id', $tag);
                        });
                    }
                }]);

                // this get the prototypes that have at least one question with all the tags
                $prototypes = $prototypes->whereHas('questions', function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->whereHas('latest.tags', function ($query) use ($tag) {
                            $query->where('tags.id', $tag);
                        });
                    }
                });
            }
        }

        if ($request->where_subject_id) {
            $prototypes = $prototypes->where('subject_id', $request->where_subject_id);
        }

        return new StatementPrototypeCollection($prototypes->paginate(5));
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
