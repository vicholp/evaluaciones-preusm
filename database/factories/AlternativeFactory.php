<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlternativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $options = ['A', 'B', 'C', 'D', 'E'];
        $choice = $this->faker->unique()->numberBetween(900, 904);
        $name = $options[$choice-900];

        return [
            'question_id' => Question::factory(),
            'name' => $name,
            'correct' => false,
            'position' => $choice,
        ];
    }

    public function correct()
    {
        return $this->state(function (array $attributes) {
            return [
                'correct' => true,
            ];
        });
    }
}
