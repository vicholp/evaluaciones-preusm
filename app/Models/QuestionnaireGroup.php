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
 * @property-read \App\Models\Period $period
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Questionnaire[] $questionnaires
 * @property-read int|null $questionnaires_count
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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'period_id',
        'start_date',
        'end_date',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class);
    }
}
