<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Division.
 *
 * @property int                                                                $id
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property string                                                             $name
 * @property int                                                                $subject_id
 * @property int|null                                                           $teacher_id
 * @property int                                                                $study_plan_id
 * @property int                                                                $period_id
 * @property \App\Models\Period                                                 $period
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property int|null                                                           $students_count
 * @property \App\Models\StudyPlan                                              $studyPlan
 * @property \App\Models\Subject                                                $subject
 *
 * @method static \Database\Factories\DivisionFactory            factory($count = null, $state = [])
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
 *
 * @mixin \Eloquent
 */
class Division extends Model
{
    use HasFactory;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<StudyPlan, Division>
     */
    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Period, Division>
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Subject, Division>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Student>
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
