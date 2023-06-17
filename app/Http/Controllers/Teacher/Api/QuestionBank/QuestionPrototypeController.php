<?php

namespace App\Http\Controllers\Teacher\Api\QuestionBank;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionPrototypeCollection;
use App\Models\QuestionnairePrototype;
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

        if ($request->where_in_questionnaire_prototype) {
            $questionnairePrototypeLatest = QuestionnairePrototype::findOrFail( // @phpstan-ignore-line
                $request->where_in_questionnaire_prototype
            )->latest;

            $prototypes = $prototypes->whereIn(
                'id',
                $questionnairePrototypeLatest->questions->pluck('id') // @phpstan-ignore-line
            );
        }

        return new QuestionPrototypeCollection($prototypes->paginate(10));
    }
}
