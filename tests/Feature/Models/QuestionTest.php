<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Student;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Services\Stats\QuestionStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    Question::factory()->create();

    expect(Question::count())->toBe(1);
});

it('has alternatives', function () {
    $question = Question::factory()->create();

    Alternative::factory()->count(3)->for($question)->create();

    expect($question->alternatives->count())->toBe(3);
});

it('has students who answered', function () {
    $question = Question::factory()->createWith();
    $students = Student::factory()->count(10)->create();

    foreach ($students as $student) {
        $student->attachAlternative($question->alternatives()->inRandomOrder()->first());
    }

    expect($question->students->count())->toBe($students->count());
});

it('belongs to a questionnaire', function () {
    $question = Question::factory()->create();

    expect($question->questionnaire)->not()->toBeNull();
});

it('is related to many tags', function () {
    $question = Question::factory()->create();
    $tags = Tag::factory()->count(10)->create();

    foreach ($tags as $tag) {
        $question->tags()->attach($tag);
    }

    expect($question->tags->count())->toBe($tags->count());
});

it('has stats', function () {
    $question = Question::factory()->create();

    expect($question->stats())->toBeInstanceOf(QuestionStatsService::class);
});

it('has topics', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('topic')->first();

    $tags = Tag::factory()->for($tagGrup)->count(2)->create();

    $question->tags()->attach($tags);

    expect($question->topics->pluck('id'))->toEqualCanonicalizing($tags->pluck('id'));
});

it('has subtopics', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('subtopic')->first();

    $tags = Tag::factory()->for($tagGrup)->count(2)->create();

    $question->tags()->attach($tags);

    expect($question->subtopics->pluck('id'))->toEqualCanonicalizing($tags->pluck('id'));
});

it('has item types', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('item_type')->first();

    $tags = Tag::factory()->for($tagGrup)->count(2)->create();

    $question->tags()->attach($tags);

    expect($question->itemTypes->pluck('id'))->toEqualCanonicalizing($tags->pluck('id'));
});

it('has skills', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('skill')->first();

    $tags = Tag::factory()->for($tagGrup)->count(2)->create();

    $question->tags()->attach($tags);

    expect($question->skills->pluck('id'))->toEqualCanonicalizing($tags->pluck('id'));
});
