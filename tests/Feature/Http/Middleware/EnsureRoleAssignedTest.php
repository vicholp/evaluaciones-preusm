<?php

use App\Models\Admin;
use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('ok when role is assigned', function () {
    Period::factory()->create();

    $teacher = Teacher::factory()->create()->user;
    $admin = Admin::factory()->create()->user;
    $student = Student::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('filament.pages.dashboard'))
        ->assertOk();

    $this->actingAs($student)
        ->get(route('student.index'))
        ->assertOk();
});

it('redirect if role is not assigned', function () {
    Period::factory()->create();

    $teacher = Teacher::factory()->create()->user;
    $admin = Admin::factory()->create()->user;
    $student = Student::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('filament.pages.dashboard'))
        ->assertForbidden();

    $this->actingAs($teacher)
        ->get(route('student.index'))
        ->assertForbidden();

    $this->actingAs($admin)
        ->get(route('teacher.index'))
        ->assertForbidden();

    $this->actingAs($admin)
        ->get(route('student.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('teacher.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('filament.pages.dashboard'))
        ->assertForbidden();
});
