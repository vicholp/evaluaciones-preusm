<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Period;

class QuestionnaireGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $i = $this->faker->unique()->numberBetween(600,605)-600;
        return [
            'period_id' => Period::factory(),
            'name' => 'EG'.$i,
            'start_date' => '1-1-2020',
            'end_date' => '1-1-2020',
        ];
    }
}
