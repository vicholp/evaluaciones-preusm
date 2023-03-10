<?php

namespace App\Models;

use App\Services\Stats\QuestionStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Question.
 *
 * @property int                                                                $id
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property int                                                                $questionnaire_id
 * @property int                                                                $pilot
 * @property int                                                                $position
 * @property string|null                                                        $name
 * @property string|null                                                        $data
 * @property int|null                                                           $question_prototype_version_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Alternative[] $alternatives
 * @property int|null                                                           $alternatives_count
 * @property mixed                                                              $item_types
 * @property mixed                                                              $skills
 * @property mixed                                                              $subtopics
 * @property mixed                                                              $topics
 * @property \App\Models\QuestionPrototypeVersion|null                          $prototype
 * @property \App\Models\Questionnaire                                          $questionnaire
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Student[]     $students
 * @property int|null                                                           $students_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]         $tags
 * @property int|null                                                           $tags_count
 *
 * @method static \Database\Factories\QuestionFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePilot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionPrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 *
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
        'question_prototype_version_id',
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

    public function prototype()
    {
        return $this->belongsTo(QuestionPrototypeVersion::class, 'question_prototype_version_id');
    }

    public function getTopicsAttribute()
    {
        return $this->tags()->whereTagGroupId(1)->get();
    }

    public function getSubtopicsAttribute()
    {
        return $this->tags()->whereTagGroupId(2)->get();
    }

    public function getItemTypesAttribute()
    {
        return $this->tags()->whereTagGroupId(3)->get();
    }

    public function getSkillsAttribute()
    {
        return $this->tags()->whereTagGroupId(4)->get();
    }
}
