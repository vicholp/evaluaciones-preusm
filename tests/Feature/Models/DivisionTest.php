<?php

use App\Models\Division;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    Division::factory()->create();

    expect(Division::count())->toBe(1);
});

it('belongs to a study plan', function () {
    $division = Division::factory()->create();

    expect($division->studyPlan)->not()->toBeNull();
});

it('belongs to a subject', function () {
    $division = Division::factory()->create();

    expect($division->subject)->not()->toBeNull();
});

it('belongs to a period', function () {
    $division = Division::factory()->create();

    expect($division->period)->not()->toBeNull();
});

it('is related to many students', function () {
    $division = Division::factory()->create();
    $students = Student::factory()->count(10)->create();

    foreach ($students as $student) {
        $student->divisions()->attach($division);
    }

    expect($division->students->count())->toBe($students->count());
});
