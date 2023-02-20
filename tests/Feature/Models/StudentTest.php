<?php

use App\Models\Alternative;
use App\Models\AlternativeStudent;
use App\Models\Division;
use App\Models\Question;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a stats service', function () {
    $student = Student::factory()->create();

    expect($student->stats())->not()->toBeNull();
});

it('has an user', function () {
    $user = User::factory()->create();
    $student = Student::factory()->for($user)->create();

    expect($student->user->id)->toBe($user->id);
});

it('belongs to many divisions', function () {
    $divisions = Division::factory()->count(4)->create();
    $student = Student::factory()->create();
    $student->divisions()->attach($divisions);

    expect($student->divisions->count())->toBe(4);
});

it('can be attached to an alternative', function () {
    $student = Student::factory()->create();

    $alternative = Alternative::factory()->create();

    $student->attachAlternative($alternative);

    expect(AlternativeStudent::whereStudentId($student->id)
        ->whereAlternativeId($alternative->id)->first())->not()->toBeNull();

    expect($student->questions->count())->toBe(1);
    expect($student->questions[0]->id)->toBe($alternative->question->id);

    expect($student->questionnaires->count())->toBe(1);
    expect($student->questionnaires[0]->id)->toBe($alternative->question->questionnaire->id);
});

it('has many questionnaires', function () {
    $student = Student::factory()->create();

    $question = Question::factory()->create();

    addAlternativesToQuestion($question);

    $student->attachAlternative($question->alternatives()->first());

    expect($student->questionnaires->count())->toBe(1);
    expect($student->questionnaires[0]->id)->toBe($question->questionnaire->id);
});
