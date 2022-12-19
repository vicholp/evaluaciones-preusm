<?php

use App\Models\Alternative;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    Alternative::factory()->create();

    expect(Alternative::count())->toBe(1);
});

it('belongs to a question', function () {
    $alternative = Alternative::factory()->create();

    expect($alternative->question)->not()->toBeNull();
});

it('is related to many students', function () {
    $alternative = Alternative::factory()->create();
    $students = Student::factory()->count(10)->create();

    foreach ($students as $student) {
        $student->attachAlternative($alternative);
    }

    expect($alternative->students->count())->toBe($students->count());
});

