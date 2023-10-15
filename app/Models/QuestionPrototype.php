<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\QuestionPrototype
 *
 * @property int $id
 * @property int $subject_id
 * @property int|null $statement_prototype_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $enabled
 * @property-read string|null $description
 * @property-read string|null $name
 * @property-read \App\Models\QuestionPrototypeVersion|null $latest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionPrototypeReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\StatementPrototype|null $statement
 * @property-read \App\Models\Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionPrototypeVersion> $versions
 * @property-read int|null $versions_count
 * @method static \Database\Factories\QuestionPrototypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereStatementPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionPrototype extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'statement_prototype_id',
    ];

    /**
     * @return HasMany<QuestionPrototypeVersion>
     */
    public function versions()
    {
        return $this->hasMany(QuestionPrototypeVersion::class);
    }

    /**
     * @return HasOne<QuestionPrototypeVersion>
     */
    public function latest()
    {
        return $this->hasOne(QuestionPrototypeVersion::class)->latestOfMany();
    }

    /**
     * @return BelongsTo<Subject, QuestionPrototype>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return HasMany<QuestionPrototypeReview>
     */
    public function reviews()
    {
        return $this->hasMany(QuestionPrototypeReview::class);
    }

    /**
     * @return BelongsTo<StatementPrototype, QuestionPrototype>
     */
    public function statement()
    {
        return $this->belongsTo(StatementPrototype::class, 'statement_prototype_id');
    }

    public function getNameAttribute(): string|null
    {
        return $this->latest?->name;
    }

    public function getDescriptionAttribute(): string|null
    {
        return $this->latest?->description;
    }
}
