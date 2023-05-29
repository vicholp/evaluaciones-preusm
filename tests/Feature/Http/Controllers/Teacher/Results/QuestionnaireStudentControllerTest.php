<?php

use App\Models\Questionnaire;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has index', function () {
    $students = Student::factory()->count(3)->create();
    $questionnaire = Questionnaire::factory()->createWithAnswers(students: $students);

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.students.index', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire.student.index')
        ->assertSee($questionnaire->name)
        ->assertSee($students[0]->name);
});

it('has show', function () {
    $student = Student::factory()->create();
    $questionnaire = Questionnaire::factory()->createWithAnswers(students: $student);

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.results.questionnaires.students.show', [$questionnaire, $student]))
        ->assertOk()
        ->assertViewIs('teacher.results.questionnaire.student.show')
        ->assertViewHas('questionnaire', $questionnaire)
        ->assertViewHas('student', $student);
});
