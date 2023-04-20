<?php

namespace App\Models;

use App\Services\Grading\GradingService;
use App\Services\Stats\QuestionnaireStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Questionnaire
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $subject_id
 * @property int $questionnaire_group_id
 * @property int|null $questionnaire_prototype_version_id
 * @property-read \App\Models\Period $period
 * @property-read \App\Models\QuestionnairePrototypeVersion|null $prototype
 * @property-read \App\Models\QuestionnaireGroup $questionnaireGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\Subject $subject
 * @method static \Database\Factories\QuestionnaireFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereQuestionnaireGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereQuestionnairePrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Questionnaire whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Questionnaire extends Model
{
    use HasFactory;

    private QuestionnaireStatsService $statsService;
    private GradingService $gradingService;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'subject_id',
        'questionnaire_group_id',
        'questionnaire_prototype_version_id',
    ];

    /**
     * @return BelongsTo<QuestionnaireGroup, Questionnaire>
     */
    public function questionnaireGroup()
    {
        return $this->belongsTo(QuestionnaireGroup::class);
    }

    /**
     * @return BelongsTo<Subject, Questionnaire>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function prototype()
    {
        return $this->belongsTo(QuestionnairePrototypeVersion::class, 'questionnaire_prototype_version_id');
    }

    /**
     * @return HasMany<Question>
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function stats(): QuestionnaireStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new QuestionnaireStatsService($this);
        }

        return $this->statsService;
    }

    public function grading(): GradingService
    {
        if (!isset($this->gradingService)) {
            $this->gradingService = new GradingService($this);
        }

        return $this->gradingService;
    }

    public function getNameAttribute(): string
    {
        return $this->attributes['name'] ?? $this->questionnaireGroup->name.' '.$this->subject->name;
    }

    public function getPeriodAttribute(): Period
    {
        return $this->questionnaireGroup->period;
    }

    /**
     * @return BelongsToMany<Student>
     */
    public function students()
    {
        return $this->belongsToMany(Student::class)->using(QuestionnaireStudent::class);
    }
}
