<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\QuestionPrototypeImplementation
 *
 * @property int $id
 * @property int $question_prototype_version_id
 * @property int $question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation whereQuestionPrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeImplementation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionPrototypeImplementation extends Pivot
{
    //
}
