<?php

use App\Models\TagGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has default scope', function () {
    $tagGroup = TagGroup::default()->getBindings();

    expect($tagGroup)->toBe([
        'skill',
        'topic',
        'subtopic',
        'item_type',
    ]);
});
