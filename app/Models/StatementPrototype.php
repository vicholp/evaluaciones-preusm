<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\StatementPrototype.
 *
 * @property int                                                                                      $id
 * @property int                                                                                      $subject_id
 * @property string|null                                                                              $name
 * @property string|null                                                                              $description
 * @property string                                                                                   $body
 * @property \Illuminate\Support\Carbon|null                                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                                          $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionnairePrototypeVersion> $questionnaires
 * @property int|null                                                                                 $questionnaires_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionPrototype>             $questions
 * @property int|null                                                                                 $questions_count
 * @property \App\Models\Subject                                                                      $subject
 *
 * @method static \Database\Factories\StatementPrototypeFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class StatementPrototype extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'description',
        'body',
    ];

    /**
     * @return BelongsTo<Subject, StatementPrototype>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return HasMany<QuestionPrototype>
     */
    public function questions()
    {
        return $this->hasMany(QuestionPrototype::class);
    }

    /**
     * @return BelongsToMany<QuestionnairePrototypeVersion>
     */
    public function questionnaires()
    {
        return $this->belongsToMany(QuestionnairePrototypeVersion::class)->withPivot(['position', 'statement_position']);
    }
}
