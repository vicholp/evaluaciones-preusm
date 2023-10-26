<?php

use App\Models\QuestionPrototypeVersion;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Services\QuestionBank\QuestionPrototypeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('create new version', function () {
    it('with tags', function () {
        $latest = QuestionPrototypeVersion::factory()->create();
        $question = $latest->parent;
        $tags = Tag::factory()->count(2)->create();

        $service = new QuestionPrototypeService($question);

        $service->createNewVersion('body', 'answer', tags: $tags);

        expect($question->versions()->count())->toBe(2);
        expect($question->latest->only('body', 'answer'))->toBe([
            'body' => 'body',
            'answer' => 'answer',
        ]);
        expect($question->latest->tags->pluck('id'))->toBeEqualCollection($tags->pluck('id'));
    });
});

describe('create question', function () {
    test('create it with a single version', function () {
        $subject = Subject::inRandomOrder()->first();
        $tags = Tag::inRandomOrder()->limit(2)->get();

        $question = QuestionPrototypeService::create(
            $subject,
            'name',
            'description',
            'body',
            'answer',
            'solution',
            $tags,
        );

        expect($question->parent->versions->count())->toBe(1);
        expect($question->name)->toBe('name');
        expect($question->description)->toBe('description');
        expect($question->body)->toBe('body');
        expect($question->answer)->toBe('answer');
        expect($question->solution)->toBe('solution');
        expect($question->tags->pluck('id'))->toBeEqualCollection($tags->pluck('id'));
    });
});

describe('get attachable tags for subject', function () {
    test('default question', function () {
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
});
