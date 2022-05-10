<?php

namespace Database\Factories;

use App\Models\QuestionnaireGroup;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionnaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'sad',
            'subject_id' => Subject::factory(),
            'questionnaire_group_id' => QuestionnaireGroup::factory(),
        ];
    }
}
