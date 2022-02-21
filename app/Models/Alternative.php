<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Alternative
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $question_id
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alternative whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Alternative extends Model
{
    use HasFactory;
}
