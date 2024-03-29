<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Period.
 *
 * @property int                                                                           $id
 * @property \Illuminate\Support\Carbon|null                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                               $updated_at
 * @property string                                                                        $name
 * @property string                                                                        $start_date
 * @property string                                                                        $end_date
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Division>           $divisions
 * @property int|null                                                                      $divisions_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionnaireGroup> $questionnaireGroups
 * @property int|null                                                                      $questionnaire_groups_count
 *
 * @method static \Database\Factories\PeriodFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUpdatedAt($value)
 *
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

    /**
     * @return HasMany<QuestionnaireGroup>
     */
    public function questionnaireGroups(): HasMany
    {
        return $this->hasMany(QuestionnaireGroup::class);
    }

    /**
     * @return HasMany<Division>
     */
    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }
}
