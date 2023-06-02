<?php

use App\Exports\Sheets\QuestionnairePrototypeVersionExport;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('export questionnaire', function () {
    Storage::fake('testing');

    $questionnairePrototype = QuestionnairePrototype::factory()->hasVersions(2)->create();
    $latest = $questionnairePrototype->latest;

    $questions = QuestionPrototypeVersion::factory()->count(10)->create();

    for ($i = 0; $i < 10; ++$i) {
        $latest->questions()->attach($questions[$i], ['position' => $i + 1]);
    }

    $tagGroups = TagGroup::default()->get();

    foreach ($questions as $question) {
        foreach ($tagGroups as $tagGroup) {
            if (random_int(0, 1)) {
                continue;
            }

            $tags = Tag::factory()->create([
                'tag_group_id' => $tagGroup->id,
            ]);
            $question->tags()->attach($tags);
        }
    }

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
