<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnairePrototype
 *
 * @property int $id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\QuestionnairePrototypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnairePrototype extends Model
{
    use HasFactory;
}
