<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\QuestionnaireQuestionPrototype
 *
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireQuestionPrototype query()
 * @mixin \Eloquent
 */
class QuestionnaireQuestionPrototype extends Pivot
{
    use HasFactory;
}
