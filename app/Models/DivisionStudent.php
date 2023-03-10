<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\DivisionStudent.
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int                             $student_id
 * @property int                             $division_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DivisionStudent whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class DivisionStudent extends Pivot
{
    //
}
