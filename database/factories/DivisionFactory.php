<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\StudyPlan;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
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
            'subject_id' => Subject::factory(),
            'period_id' => Period::factory(),
            'study_plan_id' => StudyPlan::factory(),
        ];
    }
}
