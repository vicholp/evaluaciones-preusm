<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\QuestionnaireStudent
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $student_id
 * @property int|null $score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Questionnaire $questionnaire
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnaireStudent extends Pivot
{
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
