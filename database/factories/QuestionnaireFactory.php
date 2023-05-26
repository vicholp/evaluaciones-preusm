<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
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
            'subject_id' => Subject::forQuestionnaires()->inRandomOrder()->first()->id,
            'questionnaire_group_id' => QuestionnaireGroup::factory(),
        ];
    }

    /**
     * Create a questionnaire with questions using factories.
     *
     * This method should be called last in the chain of methods.
     *
     * @return Questionnaire|Collection<Questionnaire>
     */
    public function createWithQuestions(int $questions_count = 15)
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

    public function createWithAnswers(int $questions_count = 15, $students = null)
    {
        $questionnaires = $this->create();

        $questionnaires_for_return = $questionnaires;

        if ($students == null) {
            $students = Student::factory()->count(3)->create();
        }

        if ($students->count() == 1) {
            $students = collect([$students]);
        }

        if ($questionnaires->count() == 1) {
            $questionnaires = collect([$questionnaires]);
        }

        foreach ($questionnaires as $questionnaire) {
            $questions = Question::factory()->for($questionnaire)->count($questions_count)->createWithAlternatives();

            foreach ($students as $student) {
                foreach ($questions as $question) {
                    $student->attachAlternative($question->alternatives()->inRandomOrder()->first());
                }
            }
        }

        return $questionnaires_for_return;
    }
}
