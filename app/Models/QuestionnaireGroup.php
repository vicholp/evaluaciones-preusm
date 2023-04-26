<?php

namespace App\Models;

use App\Services\Stats\QuestionnaireGroupStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\QuestionnaireGroup.
 *
 * @property int                                                                      $id
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property string                                                                   $name
 * @property int                                                                      $period_id
 * @property int                                                                      $questionnaire_class_id
 * @property int                                                                      $position
 * @property string|null                                                              $start_date
 * @property string|null                                                              $end_date
 * @property string|null                                                              $stats
 * @property \App\Models\Period                                                       $period
 * @property \App\Models\QuestionnaireClass                                           $questionnaireClass
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Questionnaire> $questionnaires
 * @property int|null                                                                 $questionnaires_count
 *
 * @method static \Database\Factories\QuestionnaireGroupFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereQuestionnaireClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereStats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireGroup whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireGroup extends Model
{
    use HasFactory;

    private QuestionnaireGroupStatsService $statsService;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'period_id',
        'questionnaire_class_id',
        'position',
        'start_date',
        'end_date',
    ];

    /**
     * @return BelongsTo<Period, QuestionnaireGroup>
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * @return HasMany<Questionnaire>
     */
    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }

    /**
     * @return BelongsTo<QuestionnaireClass, QuestionnaireGroup>
     */
    public function questionnaireClass()
    {
        return $this->belongsTo(QuestionnaireClass::class);
    }

    public function getNameAttribute(): string
    {
        return $this->attributes['name'] ?? $this->questionnaireClass->name . ' ' . $this->position;
    }

    public function stats(): QuestionnaireGroupStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new QuestionnaireGroupStatsService($this);
        }

        return $this->statsService;
    }

    public function getStatsAttribute(): ?string
    {
        return $this->stats ?? null;
    }
}
