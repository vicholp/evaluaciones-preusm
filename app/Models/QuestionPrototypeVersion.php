<?php

namespace App\Models;

use App\Services\QuestionBank\ReviewService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\QuestionPrototypeVersion.
 *
 * @property int                                                                                      $id
 * @property string|null                                                                              $name
 * @property string|null                                                                              $description
 * @property string                                                                                   $body
 * @property string                                                                                   $answer
 * @property string|null                                                                              $solution
 * @property int                                                                                      $question_prototype_id
 * @property \Illuminate\Support\Carbon|null                                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                                          $updated_at
 * @property int                                                                                      $index
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question>                      $implementations
 * @property int|null                                                                                 $implementations_count
 * @property \App\Models\QuestionPrototype                                                            $parent
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionnairePrototypeVersion> $questionnaires
 * @property int|null                                                                                 $questionnaires_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionPrototypeReview>       $reviews
 * @property int|null                                                                                 $reviews_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag>                           $tags
 * @property int|null                                                                                 $tags_count
 *
 * @method static \Database\Factories\QuestionPrototypeVersionFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereQuestionPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereSolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeVersion whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionPrototypeVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'body',
        'answer',
        'solution',
    ];

    /**
     * @return HasMany<Question>
     */
    public function implementations()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return BelongsToMany<Tag>
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return BelongsToMany<QuestionnairePrototypeVersion>
     */
    public function questionnaires()
    {
        return $this->belongsToMany(QuestionnairePrototypeVersion::class)->withPivot('position');
    }

    /**
     * @return BelongsTo<QuestionPrototype, QuestionPrototypeVersion>
     */
    public function parent()
    {
        return $this->belongsTo(QuestionPrototype::class, 'question_prototype_id');
    }

    /**
     * @return HasMany<QuestionPrototypeReview>
     */
    public function reviews()
    {
        return $this->hasMany(QuestionPrototypeReview::class);
    }

    public function reviewService(): ReviewService
    {
        return new ReviewService($this);
    }

    public function getIndexAttribute(): int
    {
        $i = 1;

        foreach ($this->parent->versions as $version) {
            if ($version->id === $this->id) {
                return $i;
            }
            ++$i;
        }

        return 0;
    }
}
