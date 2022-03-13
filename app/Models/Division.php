<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Division
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $subject_id
 * @property int|null $teacher_id
 * @property int $study_plan_id
 * @property int $period_id
 * @property-read \App\Models\Period $period
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\StudyPlan $studyPlan
 * @property-read \App\Models\Subject $subject
 * @method static \Illuminate\Database\Eloquent\Builder|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereStudyPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Division extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'subject_id',
        'period_id',
        'study_plan_id',
    ];

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
