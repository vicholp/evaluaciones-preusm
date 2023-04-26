<?php

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has index', function () {
    $questionnaire = createQuestionnaire();
    $students = Student::factory()->count(3)->create();

    foreach ($students as $student) {
        answerQuestionnaireByStudent($questionnaire, $student);
    }

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.students.index', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire.student.index')
        ->assertSee($questionnaire->name)
        ->assertSee($students[0]->name);
});
