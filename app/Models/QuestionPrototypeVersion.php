<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionPrototypeVersion
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $body
 * @property string $answer
 * @property string|null $solution
 * @property int $question_prototype_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $implementations
 * @property-read int|null $implementations_count
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
}
