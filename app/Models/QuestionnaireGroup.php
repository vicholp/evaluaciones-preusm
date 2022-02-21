<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireGroup
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $period_id
 * @property string $start_date
 * @property string $end_date
 * @method static \Database\Factories\QuestionnaireGroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnaireGroup extends Model
{
    use HasFactory;
}
