<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireQuestionPrototype
 *
 * @property int $id
 * @property int $questionnaire_prototype_version_id
 * @property int $question_prototype_version_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype whereQuestionPrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype whereQuestionnairePrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnaireQuestionPrototype extends Model
{
    use HasFactory;
}
