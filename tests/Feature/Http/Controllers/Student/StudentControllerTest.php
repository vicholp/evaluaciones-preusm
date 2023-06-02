<?php

use App\Models\Period;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Period::factory()->create();
});

test('index', function () {
    $student = Student::factory()->create()->user;

    $this->actingAs($student)
        ->get(route('student.index'))
        ->assertOk()
        ->assertViewIs('student.index');
});

it('can login', function () {
    $student = Student::factory()->create()->user;

    $this->post(route('student.login'), [
        'rut' => $student->rut . '-' . $student->rut_dv,
    ])->assertRedirect(route('student.index'));
});

test('login validates rut', function () {

    $this->post(route('student.login'), [
        'rut' => '12345678-9',
    ])->assertSessionHasErrors('rut');
});

test('login check if rut exists', function () {

    $this->post(route('student.login'), [
        'rut' => '12345678-5',
    ])->assertSessionHasErrors();
});
