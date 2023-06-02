<?php

use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('index', function () {
    $questionnaires = QuestionnairePrototype::factory()
        ->count(3)
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.index')
        ->assertViewHas('questionnaires', $questionnaires);
});

it('show', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.show')
        ->assertViewHas('questionnaire', $questionnaire);
});

it('create', function () {
    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.create'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.create');
});

it('store', function () {
    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->post(route('teacher.question-bank.questionnaire-prototypes.store'), [
            'subject_id' => 1,
        ])
        ->assertRedirect(route('teacher.question-bank.questionnaire-prototypes.show', QuestionnairePrototype::first()));
});

it('edit', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->get(route('teacher.question-bank.questionnaire-prototypes.edit', $questionnaire))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.questionnaire.edit')
        ->assertViewHas('questionnaire', $questionnaire);
});

it('update', function () {
    $questionnaire = QuestionnairePrototype::factory()
        ->hasVersions()
        ->create();

    $teacher = Teacher::factory()->create()->user;

    $this->actingAs($teacher)
        ->put(route('teacher.question-bank.questionnaire-prototypes.update', $questionnaire), [
            'subject_id' => 1,
        ])
        ->assertRedirect(route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire));
});

it('has export sheet to xslx', function () {
    Excel::fake();

    $questionnairePrototype = QuestionnairePrototype::factory()
        ->hasVersions(2)
        ->create();
    $latest = $questionnairePrototype->latest;

    $questions = QuestionPrototypeVersion::factory()
        ->count(10)
        ->create();

    for ($i = 0; $i < 10; ++$i) {
        $latest->questions()->attach($questions[$i], ['position' => $i + 1]);
    }

    $tagGroups = TagGroup::default()->get();

    foreach ($questions as $question) {
        foreach ($tagGroups as $tagGroup) {
            if (random_int(0, 1)) {
                continue;
            }

            $tags = Tag::factory()->create([
                'tag_group_id' => $tagGroup->id,
            ]);
            $question->tags()->attach($tags);
        }
    }

    $teacher = Teacher::factory()->create();

    $this->actingAs($teacher->user)
        ->get(route('teacher.question-bank.questionnaire-prototypes.export-sheet-xlsx', $latest))
        ->assertOk();

    Excel::assertDownloaded('ficha.xlsx');
});
