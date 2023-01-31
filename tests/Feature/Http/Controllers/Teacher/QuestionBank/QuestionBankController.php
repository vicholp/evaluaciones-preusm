<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows index', function () {
    $this->get(route('teacher.question-bank.index'))
        ->assertOk()
        ->assertViewIs('teacher.question-bank.index');
});
