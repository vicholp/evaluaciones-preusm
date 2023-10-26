<?php

use App\Models\QuestionnairePrototype;
use Tests\Expectations\ModelExpectation;

ModelExpectation::hasRelations(
    QuestionnairePrototype::class,
    hasManyThrough: ['implementations'],
    useFactory: true,
);
