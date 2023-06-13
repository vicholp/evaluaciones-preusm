<?php

namespace Tests\Helpers;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\Tag;
use App\Models\TagGroup;

class CreateQuestionnairePrototypeFullHelper
{
    /**
     * Create a questionnaire prototype with 10 questions and 2 tags per question.
     */
    public static function call(
        int $questionsCount = 10,
    ): QuestionnairePrototype {
        $questionnairePrototype = QuestionnairePrototype::factory()->hasVersions()->create();
        $latest = $questionnairePrototype->latest;

        $questions = QuestionPrototypeVersion::factory()->count($questionsCount)->create();

        // we want to randomize the order of the questions for testing purposes
        $positions = collect()->range(1, $questionsCount)->shuffle();

        for ($i = 0; $i < 10; ++$i) {
            $latest->questions()->attach($questions[$i], [ // @phpstan-ignore-line
                'position' => $positions[$i],
            ]);
        }

        $tagGroups = TagGroup::default()->get();

        foreach ($questions as $question) {
            foreach ($tagGroups as $tagGroup) {
                if (random_int(0, 1)) {
                    continue;
                }
                $tags = Tag::factory()->count(random_int(1, 2))
                    ->for($tagGroup)->create();

                $question->tags()->attach($tags);
            }
        }

        return $questionnairePrototype;
    }
}
