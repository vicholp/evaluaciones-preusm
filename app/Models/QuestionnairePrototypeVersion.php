<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\QuestionnairePrototypeVersion
 *
 * @property int $id
 * @property string|null $name
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

    public function getItemsForEdit(): array
    {
        $items = [];
        $statements = $this->statements ?? [];

        if ($statements->isEmpty()) {
            $questions = $this->questions ?? [];

            foreach ($questions as $question) {
                $items[$question->pivot->position] = [
                    ...$question->toArray(),
                    'parent' => $question->parent,
                ];
            }

            ksort($items);

            $itemsAsArray = array_values($items);

            return $itemsAsArray;
        }

        foreach ($statements as $statement) {
            $items[$statement->pivot->position] = [
                ...$statement->toArray(),
                'questions' => []
            ];

            $questions = $this->questions()->whereIn('question_prototype_id', $statement->questions->pluck('id')->toArray())->get();

            foreach ($questions as $question) {
                $items[$statement->pivot->position]['questions'][$question->pivot->position] = [
                    ...$question->toArray(),
                    'parent' => $question->parent,
                ];
            }
        }

        ksort($items);

        $itemsAsArray = array_values($items);

        foreach ($itemsAsArray as $index => $item) {
            $itemsAsArray[$index]['questions'] = array_values($item['questions']);
        }


        return $itemsAsArray;
    }

    public function getSortedItems(): array
    {
        $itemsSorted = [];
        $questions = $this->questions ?? [];

        foreach ($questions as $question) {
            $itemsSorted[$question?->pivot->position - 1] = [ // @phpstan-ignore-line
                'type' => 'question',
                'item' => $question,
                'index' => $question->pivot->position,  // @phpstan-ignore-line
            ];
        }

        $statements = $this->statements ?? [];

        foreach ($statements as $statement) {
            $itemsSorted[$statement->pivot->position - 1] = [  // @phpstan-ignore-line
                'type' => 'statement',
                'item' => $statement,
                'index' => $statement->pivot->position,  // @phpstan-ignore-line
            ];
        }

        ksort($itemsSorted);

        $statements = 0;

        foreach ($itemsSorted as $index => $item) {
            if ($item['type'] === 'statement') {
                ++$statements;
                continue;
            }

            $itemsSorted[$index]['index'] -= $statements;
        }

        return $itemsSorted;
    }
}
