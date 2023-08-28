<?php

use App\Models\QuestionnaireImportAnswersResult;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('insert into data', function () {
    $result = QuestionnaireImportAnswersResult::factory()->create();

    $result->insertIntoData('key', 'value');

    expect($result->data->toArray())
        ->toBe(collect(['key' => 'value'])->toArray());
});
