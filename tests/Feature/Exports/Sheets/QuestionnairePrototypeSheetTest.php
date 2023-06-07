<?php

use App\Exports\Sheets\QuestionnairePrototypeVersionExport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CreateQuestionnairePrototypeFullHelper;

uses(RefreshDatabase::class);

it('export questionnaire', function () {
    Storage::fake('testing');

    $questionnairePrototype = CreateQuestionnairePrototypeFullHelper::call();
    $latest = $questionnairePrototype->latest;
    $questions = $latest->questions->sortBy('pivot.position')->values();

    Excel::store(new QuestionnairePrototypeVersionExport($latest), 'test.csv', 'testing');

    expect(Storage::disk('testing')->exists('test.csv'))->toBeTrue();

    $file = Storage::disk('testing')->get('test.csv');
    $fileLines = str($file)->explode("\n");

    expect($fileLines[0])->toContain('"nro","clave","tipo de item","eje","contenido","habilidad","piloto"');

    for ($i = 1; $i < $fileLines->count() - 1; ++$i) {
        $items = str($fileLines[$i])->explode(',')->map(fn ($item) => Str::of($item)->trim('"'));
        $question = $questions[$i - 1];

        expect($items[0]->value)->toBe("$i");
        expect($items[1]->value)->toBe($question->answer);
    }
});
