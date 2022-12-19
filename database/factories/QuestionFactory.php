<?php

namespace Database\Factories;

use App\Models\Questionnaire;
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
}
