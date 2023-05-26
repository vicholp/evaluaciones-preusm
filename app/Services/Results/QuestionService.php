<?php

namespace App\Services\Results;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\QuestionPrototypeVersion;
use Illuminate\Support\Collection;

class QuestionService
{
    public function __construct(
        private Question $question,
    ) {
        //
    }

    /**
     * @return Collection<int, Alternative>
     */
    public function createAlternatives()
    {
        $this->question->alternatives()->createMany([
            ['position' => 1, 'name' => 'A', 'correct' => false],
            ['position' => 2, 'name' => 'B', 'correct' => false],
            ['position' => 3, 'name' => 'C', 'correct' => false],
            ['position' => 4, 'name' => 'D', 'correct' => false],
            ['position' => 5, 'name' => 'E', 'correct' => false],
            ['position' => 6, 'name' => 'N/A', 'correct' => false],
        ]);

        return $this->question->alternatives;
    }

    /**
     * @return Question
     */
    public static function createFromPrototype(
        int $questionPrototypeVersionId,
        int $position,
        int $questionnaireId,
    ) {
        $questionPrototypeVersion = QuestionPrototypeVersion::findOrFail($questionPrototypeVersionId);

        $question = Question::create([
            'questionnaire_id' => $questionnaireId,
            'position' => $position,
            'data' => $questionPrototypeVersion->body,
            'question_prototype_version_id' => $questionPrototypeVersion->id,
        ]);

        $service = new self($question);

        $service->createAlternatives();

        $correctAlternative = $question->alternatives()->whereName($questionPrototypeVersion->answer)->firstOrFail();

        $correctAlternative->update(['correct' => true]);

        $question->tags()->attach($questionPrototypeVersion->tags);

        return $question;
    }

    public static function createWithAlternatives(
        int $position,
        string $questionnaireId
    ): Question {
        $question = Question::create([
            'questionnaire_id' => $questionnaireId,
            'position' => $position,
        ]);

        $service = new self($question);

        $service->createAlternatives();

        return $question;
    }

    public function markAsPilot(): void
    {
        $this->question->pilot = true; // @phpstan-ignore-line

        $this->question->save();

        $this->question->stats()->markAsOutdated();
    }

    public function unmarkAsPilot(): void
    {
        $this->question->pilot = false; // @phpstan-ignore-line

        $this->question->save();

        $this->question->stats()->markAsOutdated();
    }
}
