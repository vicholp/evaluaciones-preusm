<?php

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrderScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int|null $subject_id
 * @property string|null $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Division[] $divisions
 * @property-read int|null $divisions_count
 * @property-read Subject|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionPrototype[] $questionPrototypes
 * @property-read int|null $question_prototypes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnairePrototype[] $questionnairePrototypes
 * @property-read int|null $questionnaire_prototypes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Questionnaire[] $questionnaires
 * @property-read int|null $questionnaires_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StatementPrototype[] $statementPrototypes
 * @property-read int|null $statement_prototypes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
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
 * @method static Builder|Subject whereSubjectId($value)
 * @method static Builder|Subject whereUpdatedAt($value)
 * @method static Builder|Subject withStatementsQuestions()
 * @mixin \Eloquent
 */
class Subject extends Model
{
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
     * @param Subject          $subject
     */
    public static function isInScope($subject, $query): bool
    {
        return $query->whereId($subject->id)->exists();
    }

    /**
     * @param Builder<Subject> $query
     *
     * @return Builder<Subject>
     */
    public function scopeForQuestions($query)
    {
        return $query->whereIn('name', [
            'ciencias biologia comun',
            'ciencias biologia electivo',
            'ciencias biologia tp',
            'ciencias quimica comun',
            'ciencias quimica electivo',
            'ciencias quimica tp',
            'ciencias fisica comun',
            'ciencias fisica electivo',
            'ciencias fisica tp',
            'matematicas 1',
            'matematicas 2',
            'lenguaje',
            'historia',
        ]);
    }

    /**
     * @param Builder<Subject> $query
     *
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
     *
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
     * @param Builder<Subject> $query
     *
     * @return Builder<Subject>
     */
    public function scopeWithStatementsQuestions($query)
    {
        return $query->whereIn('name', [
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
    public function questionPrototypes()
    {
        return $this->hasMany(QuestionPrototype::class);
    }

    /**
     * @return HasMany<QuestionnairePrototype>
     */
    public function questionnairePrototypes()
    {
        return $this->hasMany(QuestionnairePrototype::class);
    }

    public function statementPrototypes()
    {
        return $this->hasMany(StatementPrototype::class);
    }

    /**
     * @return HasMany<Tag>
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * @return BelongsTo<Subject, Subject>
     */
    public function parent()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
