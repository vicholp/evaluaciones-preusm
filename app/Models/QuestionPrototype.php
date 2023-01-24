<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionPrototype
 *
 * @property int $id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\QuestionPrototypeVersion|null $latest
 * @property-read \App\Models\Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionPrototypeVersion[] $versions
 * @property-read int|null $versions_count
 * @method static \Database\Factories\QuestionPrototypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionPrototype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionPrototype extends Model
{
    use HasFactory;

    public function versions()
    {
        return $this->hasMany(QuestionPrototypeVersion::class);
    }

    public function latest()
    {
        return $this->hasOne(QuestionPrototypeVersion::class)->latestOfMany();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
