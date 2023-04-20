<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatementPrototype>
 */
class StatementPrototypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $body = '';

        for ($i = 0; $i < rand(3, 12); ++$i) {
            $body .= '<p>' . $this->faker->paragraph() . '</p>';
        }

        return [
            'subject_id' => Subject::inRandomOrder()->firstOrFail()->id,

            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph,
            'body' => $body,
        ];
    }

    public function forSubject(Subject $subject): StatementPrototypeFactory
    {
        return $this->state(function (array $attributes) use ($subject) {
            return [
                'subject_id' => $subject->id,
            ];
        });
    }
}
