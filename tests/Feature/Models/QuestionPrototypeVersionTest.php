<?php

use App\Models\QuestionPrototypeVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a index attribute', function () {
    $version = QuestionPrototypeVersion::factory()->count(5)->create();

    expect($version[0]->index)->toBe(1);
});
