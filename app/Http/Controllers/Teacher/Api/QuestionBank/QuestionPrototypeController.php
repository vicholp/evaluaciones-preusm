<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Models\QuestionPrototype;
use Illuminate\Http\Request;

class QuestionPrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        return $prototypes->limit(15)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
