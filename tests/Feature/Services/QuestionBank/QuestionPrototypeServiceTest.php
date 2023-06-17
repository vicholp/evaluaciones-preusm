<?php

use App\Models\QuestionPrototypeVersion;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Services\QuestionBank\QuestionPrototypeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create new version', function () {
    $latest = QuestionPrototypeVersion::factory()->create();
    $question = $latest->parent;

    $service = new QuestionPrototypeService($question);

    $service->createNewVersion('body', 'answer');

    expect($question->versions()->count())->toBe(2);
    expect($question->latest->body)->toBe('body');
    expect($question->latest->answer)->toBe('answer');
});

test('get attachable tags for subject', function () {
    $subject = Subject::whereName('ciencias fisica')->first();
    $notRelatedSubjects = Subject::whereNotIn('id', $subject->relatedSubjects()->pluck('id') ?? [])
        ->get();
    $tagGroups = TagGroup::default()->get();

    $tags = collect();

    foreach ($tagGroups as $tagGroup) {
        // tags not active should not be returned
        Tag::factory()->count(2)
            ->for($tagGroup)->forSubject($subject)->create([
                'active' => false,
            ]);

        // tags not related to subject should not be returned
        Tag::factory()->count(2)
            ->for($tagGroup)->forSubject($notRelatedSubjects->random())->create([
                'active' => true,
            ]);

        $tags[$tagGroup->id] = collect();
        // tags related with subject should be returned
        $tags[$tagGroup->id]->push(...Tag::factory()->count(2)
            ->for($tagGroup)->create(['subject_id' => null]));

        // tags for the same subject should be returned
        $tags[$tagGroup->id]->push(...Tag::factory()->count(2)
            ->for($tagGroup)->forSubject($subject)->create());

        // tags for parents subjects should be returned
        $tags[$tagGroup->id]->push(...Tag::factory()->count(2)
            ->for($tagGroup)->forSubject($subject->parents()->random())
            ->create());

        // tags for childs subjects should be returned
        $tags[$tagGroup->id]->push(...Tag::factory()->count(2)
            ->for($tagGroup)->forSubject($subject->allChilds()->random())
            ->create());
    }

    $serviceTags = QuestionPrototypeService::getAttachableTagsForSubject($subject)
        ->map(fn ($e) => $e->pluck('id')->toArray())->toArray();

    $tags = $tags->map(fn ($e) => $e->pluck('id')->toArray())->toArray();

    expect($tags)->toBe($serviceTags);
});
