<?php

namespace Database\Factories;

use App\Models\StatementPrototype;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionPrototype>
 */
class QuestionPrototypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::forQuestions()->inRandomOrder()->first()->id,
            'statement_prototype_id' => StatementPrototype::factory(),
        ];
    }

    public function forSubject(Subject $subject): QuestionPrototypeFactory
    {
        return $this->state(function (array $attributes) use ($subject) {
            return [
                'subject_id' => $subject->id,
            ];
        });
    }

    public function withStatement(): QuestionPrototypeFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'statement_prototype_id' => StatementPrototype::factory(),
            ];
        });
    }

    public function withoutStatement(): QuestionPrototypeFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'statement_prototype_id' => null,
            ];
        });
    }
}
