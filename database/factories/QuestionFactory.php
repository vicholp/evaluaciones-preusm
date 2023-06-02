<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionPrototypeVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'name' => $this->faker->unique()->numberBetween(1, 100000),
            'position' => $this->faker->unique()->numberBetween(1, 100000),
            'question_prototype_version_id' => random_int(0, 1) ? QuestionPrototypeVersion::factory()->create() : null,
            'data' => random_int(0, 1) ? $this->faker->text(200) : null,
            'pilot' => random_int(0, 1),
        ];
    }

    public function pilot()
    {
        return $this->state(function (array $attributes) {
            return [
                'pilot' => true,
            ];
        });
    }

    public function createWith(
        bool $alternatives = true,
    ) {
        $questions = $this->create();

        $questions_for_return = $questions;

        if ($questions instanceof Question) {
            $questions = collect([$questions]);
        }

        if ($alternatives) {
            foreach ($questions as $question) {
                $this->attachAlternatives($question);
            }
        }

        return $questions_for_return;
    }

    /**
     * Attach default alternatives to question.
     */
    private function attachAlternatives(Question $question): Question
    {
        $question->alternatives()->createMany([
            [
                'name' => 'A',
                'position' => 1,
                'correct' => false,
            ],
            [
                'name' => 'B',
                'position' => 2,
                'correct' => false,
            ],
            [
                'name' => 'C',
                'position' => 3,
                'correct' => false,
            ],
            [
                'name' => 'D',
                'position' => 4,
                'correct' => false,
            ],
            [
                'name' => 'E',
                'position' => 5,
                'correct' => false,
            ],
        ]);

        $question->alternatives()->inRandomOrder()->first()->update([
            'correct' => true,
        ]);

        $question->alternatives()->create([
            'name' => 'N/A',
            'position' => 6,
            'correct' => false,
        ]);

        return $question;
    }
}
