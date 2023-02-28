<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\AlternativeStudent
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $student_id
 * @property int $alternative_id
 * @property int|null $question_id
 * @property int|null $questionnaire_id
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereAlternativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlternativeStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AlternativeStudent extends Pivot
{
    //
}
