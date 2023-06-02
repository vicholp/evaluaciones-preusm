<?php

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows index', function () {
    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.index');
});
