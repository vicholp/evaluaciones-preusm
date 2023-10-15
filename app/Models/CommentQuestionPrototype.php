<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CommentQuestionPrototype
 *
 * @property int $id
 * @property int $question_prototype_id
 * @property int $user_id
 * @property int $question_prototype_version_id
 * @property string $content
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\QuestionPrototype $questionPrototype
 * @property-read \App\Models\QuestionPrototypeVersion $questionPrototypeVersion
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereQuestionPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereQuestionPrototypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentQuestionPrototype whereUserId($value)
 * @mixin \Eloquent
 */
class CommentQuestionPrototype extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, CommentQuestionPrototype>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<QuestionPrototype, CommentQuestionPrototype>
     */
    public function questionPrototype()
    {
        return $this->belongsTo(QuestionPrototype::class);
    }

    /**
     * @return BelongsTo<QuestionPrototypeVersion, CommentQuestionPrototype>
     */
    public function questionPrototypeVersion()
    {
        return $this->belongsTo(QuestionPrototypeVersion::class);
    }
}
