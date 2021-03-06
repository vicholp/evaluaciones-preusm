<?php

namespace App\Models;

use App\Services\Stats\QuestionStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $questionnaire_id
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
 * @property int $pilot
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alternative[] $alternatives
 * @property-read int|null $alternatives_count
 * @property-read mixed $answers
 * @property-read mixed $discrimination_efficiency_score
 * @property-read mixed $discrimination_index_score
 * @property-read mixed $effective_weight_score
 * @property-read mixed $facility_index_score
 * @property-read mixed $full_score
 * @property-read mixed $item_type
 * @property-read mixed $random_guess_score_score
 * @property-read mixed $skill
 * @property-read mixed $subtopic
 * @property-read mixed $topic
 * @property-read mixed $with_alternatives
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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'questionnaire_id',
        'name',
        'correct',
        'position',

        'facility_index',
        'standart_deviation',
        'random_guess_score',
        'intended_weight',
        'effective_weight',
        'discrimination_index',
        'discrimination_efficiency',
    ];

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('correct');;
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getWithAlternativesAttribute()
    {
        return $this->alternatives->count() <= 6;
    }

    public function getFacilityIndexScoreAttribute()
    {
        return 0.25 > $this->facility_index || $this->facility_index > 0.75 ? 1 : 0;
    }

    public function getRandomGuessScoreScoreAttribute()
    {
        return $this->random_guess_score > 0.4 ? 1 : 0;
    }

    public function getEffectiveWeightScoreAttribute()
    {
        return $this->effective_weight === null ? 1 : 0;
    }

    public function getDiscriminationIndexScoreAttribute()
    {
        return $this->discrimination_index < 0.3 ? 1 : 0;
    }

    public function getDiscriminationEfficiencyScoreAttribute()
    {
        return $this->discrimination_efficiency < 0.4 ? 1 : 0;
    }

    public function getFullScoreAttribute()
    {
            return $this->facility_index_score +
            $this->random_guess_score_score +
            $this->effective_weight_score +
            $this->discrimination_index_score +
            $this->discrimination_efficiency_score;
    }

    public function getAnswersAttribute()
    {
        $count = 0;

        foreach($this->alternatives as $alternative){
            $count += $alternative->students->count();
        }

        return $count;
    }

    public function stats()
    {
        return new QuestionStatsService($this);
    }

    public function getTopicAttribute()
    {
        return $this->tags->where('tag_group_id', 1)->first();
    }

    public function getSubtopicAttribute()
    {
        return $this->tags->where('tag_group_id', 2)->first();
    }

    public function getItemTypeAttribute()
    {
        return $this->tags->where('tag_group_id', 3)->first();
    }

    public function getSkillAttribute()
    {
        return $this->tags->where('tag_group_id', 4)->first();
    }
}


