<?php

namespace App\Models;

use App\Services\Stats\QuestionStudentStatsService;
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
 * @property string|null $stats
 * @property-read \App\Models\Alternative $alternative
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereAlternativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereStats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionStudent extends Pivot
{
    private QuestionStudentStatsService $statsService;

    /**
     * @return BelongsTo<Alternative, QuestionStudent>
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * @return BelongsTo<Question, QuestionStudent>
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<Student, QuestionStudent>
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function stats(): QuestionStudentStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new QuestionStudentStatsService($this);
        }

        return $this->statsService;
    }
}
