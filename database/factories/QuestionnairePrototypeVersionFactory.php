<?php

namespace Database\Factories;

use App\Models\QuestionnairePrototype;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionnairePrototypeVersion>
 */
class QuestionnairePrototypeVersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'questionnaire_prototype_id' => QuestionnairePrototype::factory(),
        ];
    }
}
