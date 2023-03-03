<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property int|null $subject_id
 * @property int $tag_group_id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionPrototypeVersion[] $questionPrototypeVersions
 * @property-read int|null $question_prototype_versions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Subject|null $subject
 * @property-read \App\Models\TagGroup $tagGroup
 * @method static \Database\Factories\TagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTagGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'tag_group_id',
    ];

    /**
     * @return BelongsTo<Subject, Tag>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return BelongsToMany<Question>
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    /**
     * @return BelongsTo<TagGroup, Tag>
     */
    public function tagGroup()
    {
        return $this->belongsTo(TagGroup::class);
    }

    public function questionPrototypeVersions()
    {
        return $this->belongsToMany(QuestionPrototypeVersion::class);
    }
}
