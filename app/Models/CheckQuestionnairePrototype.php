<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CheckQuestionnairePrototype
 *
 * @property int $id
 * @property int $check_id
 * @property int $questionnaire_prototype_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereCheckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereQuestionnairePrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckQuestionnairePrototype whereUserId($value)
 * @mixin \Eloquent
 */
class CheckQuestionnairePrototype extends Pivot
{
}
