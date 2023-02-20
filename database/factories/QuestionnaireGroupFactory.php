<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\QuestionnaireClass;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'position' => $this->faker->unique()->numberBetween(1, 1000),
        ];
    }
}
