<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionPrototypeVersion
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $body
 * @property string $answer
 * @property string|null $solution
 * @property int $question_prototype_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $implementations
 * @property-read int|null $implementations_count
 * @property-read \App\Models\QuestionPrototype|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnairePrototypeVersion[] $questionnaires
 * @property-read int|null $questionnaires_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\QuestionPrototypeVersionFactory factory(...$parameters)
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
    ];

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

    public function questionnaires()
    {
        return $this->belongsToMany(QuestionnairePrototypeVersion::class)->withPivot('position');
    }

    public function parent()
    {
        return $this->belongsTo(QuestionPrototype::class);
    }

    public function subject()
    {
        return $this->parent->subject();
    }
}
