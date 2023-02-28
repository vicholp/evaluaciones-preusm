<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\QuestionnairePrototypeVersion
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $questionnaire_prototype_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionPrototypeVersion[] $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StatementPrototype[] $statements
 * @property-read int|null $statements_count
 * @method static \Database\Factories\QuestionnairePrototypeVersionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereQuestionnairePrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnairePrototypeVersion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnairePrototypeVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return BelongsToMany<QuestionPrototypeVersion>
     */
    public function questions()
    {
        return $this->belongsToMany(QuestionPrototypeVersion::class)->withPivot('position');
    }

    /**
     * @return BelongsToMany<StatementPrototype>
     */
    public function statements()
    {
        return $this->belongsToMany(StatementPrototype::class)->withPivot(['position', 'statement_position']);
    }
}
