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
        $name = $this->faker->unique()->numberBetween(800, 805);

        return [
            'questionnaire_id' => Questionnaire::factory(),
            'name' => $name-800,
            'position' => $name-800,
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
