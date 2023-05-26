<?php

namespace App\Models;

use App\Models\Scopes\AlphabeticalOrderScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Subject.
 *
 * @property int                                                                               $id
 * @property \Illuminate\Support\Carbon|null                                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                                   $updated_at
 * @property string                                                                            $name
 * @property int|null                                                                          $subject_id
 * @property string|null                                                                       $color
 * @property \Illuminate\Database\Eloquent\Collection<int, Subject>                            $childs
 * @property int|null                                                                          $childs_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Division>               $divisions
 * @property int|null                                                                          $divisions_count
 * @property Subject|null                                                                      $parent
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionPrototype>      $questionPrototypes
 * @property int|null                                                                          $question_prototypes_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionnairePrototype> $questionnairePrototypes
 * @property int|null                                                                          $questionnaire_prototypes_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Questionnaire>          $questionnaires
 * @property int|null                                                                          $questionnaires_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\StatementPrototype>     $statementPrototypes
 * @property int|null                                                                          $statement_prototypes_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag>                    $tags
 * @property int|null                                                                          $tags_count
 *
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
 *
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
    public function scopeForElectives($query)
    {
        return $query->whereIn('name', [
            'ciencias biologia',
            'ciencias quimica',
            'ciencias fisica',
            'ciencias TP',
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

    public function getGradableSubjectAttribute(): Subject
    {
        if ($this->forQuestionnaires()->whereId($this->id)->exists()) {
            return $this;
        }

        return $this->forQuestionnaires()->whereIn('id', $this->parents()->pluck('id'))->first();
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

    /**
     * @return HasMany<StatementPrototype>
     */
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

    /**
     * Returns all the parents recursive of the subject.
     */
    public function parents(): mixed
    {
        $parents = collect();

        $parent = $this->parent;

        while ($parent) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    /**
     * @return HasMany<Subject>
     */
    public function childs()
    {
        return $this->hasMany(Subject::class, 'subject_id');
    }

    /**
     * Returns all the childs recursive of the subject.
     */
    public function allChilds(): mixed
    {
        $childs = collect();

        $childs->push($this);

        foreach ($this->childs as $child) {
            $childs = $childs->merge($child->allChilds());
        }

        return $childs;
    }

    public function relatedSubjects(): mixed
    {
        return $this->allChilds()->merge($this->parents());
    }
}
