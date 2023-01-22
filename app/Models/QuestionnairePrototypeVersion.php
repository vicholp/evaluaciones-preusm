<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnairePrototypeVersion
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $questionnaire_prototype_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\QuestionnairePrototypeVersionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereQuestionnairePrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnairePrototypeVersion extends Model
{
    use HasFactory;
}
