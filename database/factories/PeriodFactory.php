<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $year = $this->faker->unique()->year();

        $end_date = $this->faker->date('Y-m-d', $year . '-01-01');
        $start_date = $this->faker->date('Y-m-d', $end_date);

        return [
            'name' => $year,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
