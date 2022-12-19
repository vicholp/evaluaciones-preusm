<?php

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
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
    $question = Question::factory()->create();

    $students = Student::factory()->count(10)->create();

    addAlternativesToQuestion($question);

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

it('has topic attribute', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('topic')->first();

    $tag = Tag::factory()->for($tagGrup)->create();

    $tag->questions()->attach($question);

    expect($question->topic->id)->toBe($tag->id);
});

it('has subtopic attribute', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('subtopic')->first();

    $tag = Tag::factory()->for($tagGrup)->create();

    $tag->questions()->attach($question);

    expect($question->subtopic->id)->toBe($tag->id);
});

it('has item type attribute', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('item_type')->first();

    $tag = Tag::factory()->for($tagGrup)->create();

    $tag->questions()->attach($question);

    expect($question->itemType->id)->toBe($tag->id);
});

it('has skill attribute', function () {
    $question = Question::factory()->create();
    $tagGrup = TagGroup::whereName('skill')->first();

    $tag = Tag::factory()->for($tagGrup)->create();

    $tag->questions()->attach($question);

    expect($question->skill->id)->toBe($tag->id);
});
