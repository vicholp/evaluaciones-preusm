<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

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

    public function forSubject(Subject $subject): QuestionnaireFactory
    {
        return $this->state(function (array $attributes) use ($subject) {
            return [
                'subject_id' => $subject->id,
            ];
        });
    }

    /**
     * Create a default questionnaire with questions and alternatives.
     *
     * @return Questionnaire|Collection<Questionnaire>
     */
    public function createWith(
        int|false $questions = 15,
        int|false $answers = 5,
    ) {
        $questionnaires = $this->create();

        $questionnaires_for_return = $questionnaires;

        if ($questionnaires instanceof Questionnaire) {
            $questionnaires = collect([$questionnaires]);
        }

        if ($questions) {
            foreach ($questionnaires as $questionnaire) {
                Question::factory()->for($questionnaire)->count($questions)->createWith();
            }

            if ($answers) {
                $students = Student::factory()->count($answers)->create();

                if ($students instanceof Student) {
                    $students = collect([$students]);
                }

                foreach ($questionnaires as $questionnaire) {
                    $this->attachResponses($questionnaire, $students);
                }
            }
        }

        return $questionnaires_for_return;
    }

    private function attachResponses(
        Questionnaire $questionnaire,
        Collection $students,
    ): Questionnaire {
        foreach ($questionnaire->questions as $question) {
            $alternative = $question->alternatives()->inRandomOrder()->first();

            foreach ($students as $student) {
                $student->attachAlternative($alternative);
            }
        }

        return $questionnaire;
    }

    public function createWithAnswers(
        int $questions_count = 15,
        int $students_count = 3,
        $students = null
    ) {
        $questionnaires = $this->create();

        $questionnaires_for_return = $questionnaires;

        if ($students == null) {
            $students = Student::factory()->count($students_count)->create();
        }

        if ($students instanceof Student) {
            $students = collect([$students]);
        }

        if ($questionnaires instanceof Questionnaire) {
            $questionnaires = collect([$questionnaires]);
        }

        foreach ($questionnaires as $questionnaire) {
            $questions = Question::factory()->for($questionnaire)->count($questions_count)->createWith();

            foreach ($students as $student) {
                foreach ($questions as $question) {
                    $student->attachAlternative($question->alternatives()->inRandomOrder()->first());
                }
            }
        }

        return $questionnaires_for_return;
    }
}
