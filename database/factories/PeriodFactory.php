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

        return [
            'name' => $year,
            'start_date' => rand(1,25).'-'.rand(1,3).$year,
            'end_date' => rand(1,25).'-'.rand(10,12).$year,
        ];
    }
}
