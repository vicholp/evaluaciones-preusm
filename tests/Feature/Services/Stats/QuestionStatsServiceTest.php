<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Support\Facades\Artisan;

beforeEach(function() {
    Artisan::call('migrate:fresh');
});

test('average in normal question',function () {
    $question = Question::factory()->create();
    $students = Student::factory()->count(2)->create();

    Alternative::factory()->for($question)->create()->students()->attach($students[0]);
    Alternative::factory()->for($question)->correct()->create()->students()->attach($students[1]);

    expect($question->stats()->computeAverageScore(Student::get()))->toBe(0.5);
});

test('average in pilot question',function () {
    $question = Question::factory()->pilot()->create();
    $students = Student::factory()->count(2)->create();

    Alternative::factory()->for($question)->create()->students()->attach($students[0]);
    Alternative::factory()->for($question)->correct()->create()->students()->attach($students[1]);

    expect($question->stats()->computeAverageScore(Student::get()))->toBe(0.0);
});









