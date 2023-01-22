<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionPrototypeVersion>
 */
class QuestionPrototypeVersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $alternatives = [
            'A' => $this->faker->sentence(3),
            'B' => $this->faker->sentence(3),
            'C' => $this->faker->sentence(3),
            'D' => $this->faker->sentence(3),
            'E' => $this->faker->sentence(3),
        ];

        $alternatives_text = '';

        foreach ($alternatives as $key => $value) {
            $alternatives_text .= $key . ') ' . $value . '\n';
        }

        $body = $this->faker->paragraph() . '\n' . $alternatives_text;

        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
