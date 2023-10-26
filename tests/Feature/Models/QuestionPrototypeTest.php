<?php

use App\Models\QuestionPrototype;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Expectations\ModelExpectation;

uses(RefreshDatabase::class);

ModelExpectation::hasRelations(
    QuestionPrototype::class,
    hasMany: ['versions'],
    hasOne: ['latest'],
    belongsTo: ['subject', 'statement'],
);
