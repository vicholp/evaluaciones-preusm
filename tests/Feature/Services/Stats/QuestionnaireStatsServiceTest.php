<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Support\Facades\Artisan;

beforeEach(function() {
    Artisan::call('migrate:fresh');
});

test('average in questionnaire without pilot question',function () {
    $question = Question::factory()->create();
    $students = Student::factory()->count(2)->create();

    Alternative::factory()->for($question)->create()->students()->attach($students[0]);
    Alternative::factory()->for($question)->correct()->create()->students()->attach($students[1]);

    expect($question->questionnaire->stats()->average($students))->toBe(0.5);
});

test('average in questionnaire with pilot question',function () {
    $question = Question::factory()->pilot()->create();
    $students = Student::factory()->count(2)->create();

    Alternative::factory()->for($question)->create()->students()->attach($students[0]);
    Alternative::factory()->for($question)->correct()->create()->students()->attach($students[1]);

    expect($question->questionnaire->stats()->average($students))->toBe(0.0);
});

test('average of students', function () {
    $questionnaire = Questionnaire::factory()->create();
    $question = Question::factory()->for($questionnaire)->count(2)->create();
    $students = Student::factory()->count(2)->create();

    Alternative::factory()->for($question[0])->correct()->create()->students()->attach($students);
    Alternative::factory()->for($question[1])->create()->students()->attach($students[0]);
    Alternative::factory()->for($question[1])->correct()->create()->students()->attach($students[1]);

    expect($questionnaire->stats()->average($students))->toBe(0.75);
});



