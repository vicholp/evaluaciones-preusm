<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\QuestionTag.
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int                             $tag_id
 * @property int                             $question_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionTag extends Pivot
{
    //
}
