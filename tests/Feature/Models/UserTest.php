<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has factory', function () {
    $user = User::factory()->create();

    expect(User::count())->toBe(1);
});
