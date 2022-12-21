<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has index', function () {
    $questionnaire = createQuestionnaire();
    $students = Student::factory()->count(3)->create();

    foreach ($students as $student) {
        answerQuestionnaireByStudent($questionnaire, $student);
    }

    $this->get(route('teacher.questionnaires.students.index', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.questionnaire.student.index')
        ->assertSee($questionnaire->name)
        ->assertSee($students[0]->name);
});
