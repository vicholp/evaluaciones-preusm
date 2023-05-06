<?php

namespace Database\Factories;

use App\Models\Alternative;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Create a question with alternatives.
     *
     * This method should be called last in the chain of methods.
     *
     * @return Question|Collection<Question>
     */
    public function createWithAlternatives()
    {
        $questions = $this->create();

        $questions_for_return = $questions;

        if ($questions->count() == 1) {
            $questions = collect([$questions]);
        }

        foreach ($questions as $question) {
            Alternative::create([
                'name' => 'A',
                'question_id' => $question->id,
                'position' => 1,
                'correct' => false,
            ]);
            Alternative::create([
                'name' => 'B',
                'question_id' => $question->id,
                'position' => 2,
                'correct' => false,
            ]);
            Alternative::create([
                'name' => 'C',
                'question_id' => $question->id,
                'position' => 3,
                'correct' => false,
            ]);
            Alternative::create([
                'name' => 'D',
                'question_id' => $question->id,
                'position' => 4,
                'correct' => false,
            ]);
            Alternative::create([
                'name' => 'E',
                'question_id' => $question->id,
                'position' => 5,
                'correct' => false,
            ]);

            $question->alternatives->random()->update(['correct' => true]);

            Alternative::create([
                'name' => 'N/A',
                'question_id' => $question->id,
                'position' => 6,
                'correct' => false,
            ]);
        }

        return $questions_for_return;
    }
}
