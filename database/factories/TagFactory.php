<?php

namespace Database\Factories;

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
            'tag_group_id' => TagGroup::factory(),
            'name' => $this->faker->text('20'),
        ];
    }
}
