<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Alternative.
 *
 * @property int                                                                $id
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property int                                                                $question_id
 * @property int                                                                $position
 * @property string                                                             $name
 * @property string|null                                                        $data
 * @property int                                                                $correct
 * @property \App\Models\Question                                               $question
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property int|null                                                           $students_count
 *
 * @method static \Database\Factories\AlternativeFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Alternative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'name',
        'position',
        'correct',
        'data',
    ];

    /**
     * @return belongsToMany<Student>
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * @return belongsTo<Question, Alternative>
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
