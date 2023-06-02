<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('sent count', function () {
    $questionnaireGroup = QuestionnaireGroup::factory()->create();
    $questionnaires = Questionnaire::factory()->for($questionnaireGroup)->count(3)->create();
    $students = Student::factory()->count(10)->create();

    $count = 0;

    foreach ($questionnaires as $questionnaire) {
        $questions = Question::factory()->count(3)->for($questionnaire)->createWith();

        foreach ($students as $student) {
            if (rand(0, 1)) {
                foreach ($questions as $question) {
                    $student->attachAlternative($question->alternatives()->inRandomOrder()->first());
                }
                ++$count;
            }
        }
    }

    expect($questionnaireGroup->stats()->getSentCount())->toBe($count);
});
