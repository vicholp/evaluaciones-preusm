<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CheckQuestionPrototype.
 *
 * @property int                             $id
 * @property int                             $check_id
 * @property int                             $question_prototype_id
 * @property int|null                        $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereCheckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereQuestionPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionPrototype whereUserId($value)
 *
 * @mixin \Eloquent
 */
class CheckQuestionPrototype extends Pivot
{
    //
}
