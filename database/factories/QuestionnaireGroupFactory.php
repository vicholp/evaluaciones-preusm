<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Period;
use App\Models\QuestionnaireClass;

class QuestionnaireGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'period_id' => Period::factory(),
            'questionnaire_class_id' => QuestionnaireClass::inRandomOrder()->first()->id,
            'position' => $this->faker->unique()->numberBetween(1, 15),
        ];
    }
}
