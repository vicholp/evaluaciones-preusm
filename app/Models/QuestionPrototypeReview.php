<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\QuestionPrototypeReview.
 *
 * @property int                                  $id
 * @property int                                  $question_prototype_id
 * @property int                                  $user_id
 * @property int                                  $question_prototype_version_id
 * @property \Illuminate\Support\Carbon|null      $created_at
 * @property \Illuminate\Support\Carbon|null      $updated_at
 * @property \App\Models\QuestionPrototype        $questionPrototype
 * @property \App\Models\QuestionPrototypeVersion $questionPrototypeVersion
 * @property \App\Models\User                     $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereQuestionPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereQuestionPrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototypeReview whereUserId($value)
 *
 * @mixin \Eloquent
 */
class QuestionPrototypeReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_prototype_id',
        'user_id',
        'question_prototype_version_id',
    ];

    /**
     * @return BelongsTo<User, QuestionPrototypeReview>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<QuestionPrototype, QuestionPrototypeReview>
     */
    public function questionPrototype()
    {
        return $this->belongsTo(QuestionPrototype::class);
    }

    /**
     * @return BelongsTo<QuestionPrototypeVersion, QuestionPrototypeReview>
     */
    public function questionPrototypeVersion()
    {
        return $this->belongsTo(QuestionPrototypeVersion::class);
    }
}
