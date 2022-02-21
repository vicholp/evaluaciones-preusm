<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Period
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnaireGroup[] $questionnaireGroups
 * @property-read int|null $questionnaire_groups_count
 * @method static \Database\Factories\PeriodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    public function questionnaireGroups()
    {
        return $this->hasMany(QuestionnaireGroup::class);
    }

}
