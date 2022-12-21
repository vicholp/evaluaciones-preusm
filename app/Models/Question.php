<?php

namespace App\Models;

use App\Services\Stats\QuestionStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $questionnaire_id
 * @property int $pilot
 * @property int $position
 * @property string $name
 * @property string|null $data
 * @property float|null $facility_index
 * @property float|null $standart_deviation
 * @property float|null $random_guess_score
 * @property float|null $intended_weight
 * @property float|null $effective_weight
 * @property float|null $discrimination_index
 * @property float|null $discrimination_efficiency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alternative[] $alternatives
 * @property-read int|null $alternatives_count
 * @property-read \App\Models\Tag|null $item_type
 * @property-read \App\Models\Tag|null $skill
 * @property-read \App\Models\Tag|null $subtopic
 * @property-read \App\Models\Tag|null $topic
 * @property-read \App\Models\Questionnaire $questionnaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\QuestionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDiscriminationEfficiency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDiscriminationIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereEffectiveWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereFacilityIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereIntendedWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePilot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereRandomGuessScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereStandartDeviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;

    private QuestionStatsService $statsService;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'questionnaire_id',
        'name',
        'position',
    ];

    /**
     * @return HasMany<Alternative>
     */
    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }

    /**
     * @return BelongsToMany<Student>
     */
    public function students()
    {
        return $this->belongsToMany(Student::class)->using(QuestionStudent::class)->withPivot('alternative_id');
    }

    /**
     * @return BelongsTo<Questionnaire, Question>
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * @return BelongsToMany<Tag>
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function stats(): QuestionStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new QuestionStatsService($this);
        }

        return $this->statsService;
    }

    public function getTopicAttribute(): Tag|null
    {
        return $this->tags()->where('tag_group_id', 1)->first();
    }

    public function getSubtopicAttribute(): Tag|null
    {
        return $this->tags()->where('tag_group_id', 2)->first();
    }

    public function getItemTypeAttribute(): Tag|null
    {
        return $this->tags()->where('tag_group_id', 3)->first();
    }

    public function getSkillAttribute(): Tag|null
    {
        return $this->tags()->where('tag_group_id', 4)->first();
    }
}
