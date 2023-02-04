<?php

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrderScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Division[] $divisions
 * @property-read int|null $divisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionPrototype[] $questionPrototype
 * @property-read int|null $question_prototype_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnairePrototype[] $questionnairePrototype
 * @property-read int|null $questionnaire_prototype_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Questionnaire[] $questionnaires
 * @property-read int|null $questionnaires_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\SubjectFactory factory(...$parameters)
 * @method static Builder|Subject forQuestionnairePrototypes()
 * @method static Builder|Subject forQuestionnaires()
 * @method static Builder|Subject forQuestions()
 * @method static Builder|Subject newModelQuery()
 * @method static Builder|Subject newQuery()
 * @method static Builder|Subject query()
 * @method static Builder|Subject whereColor($value)
 * @method static Builder|Subject whereCreatedAt($value)
 * @method static Builder|Subject whereId($value)
 * @method static Builder|Subject whereName($value)
 * @method static Builder|Subject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'color',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AlphabeticalOrderScope());
    }

    /**
     * @param Builder<Subject> $query
     * @return Builder<Subject>
     */
    public function scopeForQuestions($query)
    {
        return $query->whereNotIn('name', [
            'terceros',
            'ciencias quimica',
            'ciencias fisica',
            'ciencias biologia',
            'ciencias TP',
        ]);
    }

    /**
     * @param Builder<Subject> $query
     * @return Builder<Subject>
     */
    public function scopeForQuestionnaires($query)
    {
        return $query->whereIn('name', [
            'matematicas 1',
            'matematicas 2',
            'ciencias biologia',
            'ciencias fisica',
            'ciencias quimica',
            'ciencias TP',
            'historia',
            'lenguaje',
        ]);
    }

    /**
     * @param Builder<Subject> $query
     * @return Builder<Subject>
     */
    public function scopeForQuestionnairePrototypes($query)
    {
        return $query->whereIn('name', [
            'matematicas terceros',
            'matematicas 1',
            'matematicas 2',
            'ciencias biologia',
            'ciencias biologia comun',
            'ciencias biologia electivo',
            'ciencias biologia TP',
            'ciencias fisica',
            'ciencias fisica comun',
            'ciencias fisica electivo',
            'ciencias fisica TP',
            'ciencias quimica',
            'ciencias quimica comun',
            'ciencias quimica electivo',
            'ciencias quimica TP',
            'ciencias TP',
            'historia',
            'lenguaje',
        ]);
    }

    /**
     * @return HasMany<Questionnaire>
     */
    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class);
    }

    /**
     * @return HasMany<Division>
     */
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    /**
     * @return HasMany<QuestionPrototype>
     */
    public function questionPrototype()
    {
        return $this->hasMany(QuestionPrototype::class);
    }

    /**
     * @return HasMany<QuestionnairePrototype>
     */
    public function questionnairePrototype()
    {
        return $this->hasMany(QuestionnairePrototype::class);
    }

    /**
     * @return HasMany<Tag>
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
