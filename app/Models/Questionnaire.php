<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Questionnaire
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $pilot
 * @property int $subject_id
 * @property int $questionnaire_group_id
 * @property float|null $average
 * @property float|null $standart_deviation
 * @property float|null $skewness
 * @property float|null $kurtosis
 * @property float|null $coefficient_internal_consistency
 * @property float|null $error_ratio
 * @property float|null $standard_error
 * @property-read mixed $period
 * @property-read \App\Models\QuestionnaireGroup $questionnaireGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Subject $subject
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereCoefficientInternalConsistency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereErrorRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereKurtosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire wherePilot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereQuestionnaireGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereSkewness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereStandardError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereStandartDeviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Questionnaire extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'subject_id',
        'questionnaire_group_id',

        'average',
        'standart_deviation',
        'skewness',
        'kurtosis',
        'coefficient_internal_consistency' ,
        'error_ratio',
        'standard_error',
    ];

    public function questionnaireGroup()
    {
        return $this->belongsTo(QuestionnaireGroup::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getPeriodAttribute()
    {
        return $this->questionnaireGroup->period;
    }
}
