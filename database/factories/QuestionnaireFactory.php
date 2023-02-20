<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Questionnaire;
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
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'questionnaire_group_id' => QuestionnaireGroup::factory(),
        ];
    }

    /**
     * Create a questionnaire with questions using factories.
     *
     * This method should be called last in the chain of methods.
     */
    public function createWithQuestions(int $questions_count = 60)
    {
        $questionnaires = $this->create();

        $questionnaires_for_return = $questionnaires;

        if ($questionnaires->count() == 1) {
            $questionnaires = collect([$questionnaires]);
        }

        foreach ($questionnaires as $questionnaire) {
            Question::factory()->for($questionnaire)->count($questions_count)->createWithAlternatives();
        }

        return $questionnaires_for_return;
    }
}
