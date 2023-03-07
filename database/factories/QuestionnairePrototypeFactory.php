<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionnairePrototype>
 */
class QuestionnairePrototypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function forSubject(Subject $subject): QuestionnairePrototypeFactory
    {
        return $this->state(function (array $attributes) use ($subject) {
            return [
                'subject_id' => $subject->id,
            ];
        });
    }
}
