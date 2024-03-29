<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\QuestionnairePrototype.
 *
 * @property int                                                                                      $id
 * @property int                                                                                      $subject_id
 * @property string                                                                                   $questions_type
 * @property \Illuminate\Support\Carbon|null                                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                                          $updated_at
 * @property int                                                                                      $enabled
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Check>                         $checks
 * @property int|null                                                                                 $checks_count
 * @property string|null                                                                              $name
 * @property \App\Models\QuestionnairePrototypeVersion|null                                           $latest
 * @property \App\Models\Subject                                                                      $subject
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionnairePrototypeVersion> $versions
 * @property int|null                                                                                 $versions_count
 *
 * @method static \Database\Factories\QuestionnairePrototypeFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereQuestionsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototype whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionnairePrototype extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
    ];

    /**
     * @return BelongsToMany<Check>
     */
    public function checks()
    {
        return $this->belongsToMany(Check::class);
    }

    /**
     * @return BelongsTo<Subject, QuestionnairePrototype>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return HasMany<QuestionnairePrototypeVersion>
     */
    public function versions()
    {
        return $this->hasMany(QuestionnairePrototypeVersion::class);
    }

    /**
     * @return HasOne<QuestionnairePrototypeVersion>
     */
    public function latest()
    {
        return $this->hasOne(QuestionnairePrototypeVersion::class)->latestOfMany();
    }

    public function getNameAttribute(): ?string
    {
        return $this->subject->name . ' - ' . $this->latest?->name;
    }
}
