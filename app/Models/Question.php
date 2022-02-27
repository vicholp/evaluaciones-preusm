<?php

namespace App\Models;

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
 * @property float|null $discrimination _index
 * @property float|null $discrimination_efficiency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alternative[] $alternatives
 * @property-read int|null $alternatives_count
 * @property-read \App\Models\Questionnaire $questionnaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
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

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getAnswersAttribute()
    {
        $count = 0;

        foreach($this->alternatives as $alternative){
            $count += $alternative->students->count();
        }

        return $count;
    }

    public function getTopicAttribute()
    {
        return $this->tags()->whereTagGroupId(1)->first();
    }

    public function getSubtopicAttribute()
    {
        return $this->tags()->whereTagGroupId(2)->first();
    }

    public function getItemTypeAttribute()
    {
        return $this->tags()->whereTagGroupId(3)->first();
    }

    public function getSkillAttribute()
    {
        return $this->tags()->whereTagGroupId(4)->first();
    }
}


