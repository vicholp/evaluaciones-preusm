<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $options = ['matematicas', 'lenguaje', 'fisica', 'historia'];
        $subject = $options[$this->faker->unique()->numberBetween(700, 703)-700];

        return [
            'name' => 'subject',
            'color' => '#FFFFFF',
        ];
    }
}
