<?php

use App\Models\Admin;
use App\Models\Questionnaire;
use App\Models\QuestionnairePrototype;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has destroy', function () {
    $admin = Admin::factory()->create();

    $prototype = QuestionnairePrototype::factory()->hasVersions(1)->create();
    $questionnaire = Questionnaire::factory()->create([
        'questionnaire_prototype_version_id' => $prototype->versions->first()->id,
    ]);

    $this->actingAs($admin->user)
        ->delete(route('admin.questionnaires.destroy', $questionnaire->id))
        ->assertRedirect(route('admin.questionnaires.index'));
});
