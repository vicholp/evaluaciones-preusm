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
