<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Support\Facades\Artisan;

beforeEach(function() {
    Artisan::call('migrate:fresh');
});

test('count gradeable questions', function () {
    $questionnaire = Questionnaire::factory()->create();

    Question::factory()->for($questionnaire)->count(1)->pilot()->create();
    Question::factory()->for($questionnaire)->count(2)->create();

    expect($questionnaire->grading()->gradableQuestions())->toBe(2);
    expect($questionnaire->grading()->pilotQuestions())->toBe(1);
});
