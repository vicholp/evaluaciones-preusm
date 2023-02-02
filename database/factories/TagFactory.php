<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\TagGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::factory(),
            'tag_group_id' => TagGroup::factory(),
            'name' => $this->faker->text('20'),
        ];
    }

    /**
     * Indicate that the tag is active.
     *
     * @return \Database\Factories\TagFactory
     */
    public function randomSubject()
    {
        return $this->state(function (array $attributes) {
            return [
                'subject_id' => rand(0,1) ? Subject::inRandomOrder()->first()->id : null,
            ];
        });
    }
}
