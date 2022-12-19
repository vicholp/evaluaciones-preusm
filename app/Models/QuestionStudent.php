<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\QuestionStudent
 *
 * @property int $id
 * @property int $question_id
 * @property int $student_id
 * @property int $alternative_id
 * @property int|null $score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alternative $alternative
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereAlternativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionStudent extends Pivot
{
    /**
     * @return BelongsTo<Alternative, QuestionStudent>
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
