<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudyPlan
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @method static \Database\Factories\StudyPlanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudyPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];
}
