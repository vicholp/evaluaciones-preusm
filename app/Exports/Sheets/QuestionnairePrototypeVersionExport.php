<?php

namespace App\Exports\Sheets;

use App\Models\QuestionnairePrototypeVersion;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionnairePrototypeVersionExport implements FromCollection
{
    public function __construct(
        private QuestionnairePrototypeVersion $questionnairePrototypeVersion
    ) {
        //
    }

    /**
     * @return \Illuminate\Support\Collection<int, array>
     */
    public function collection()
    {
        $questions = $this->questionnairePrototypeVersion->questions->sortBy('pivot.position');

        $export = collect();

        $export->push([
            'nro',
            'clave',
            'tipo de item',
            'eje',
            'contenido',
            'habilidad',
            'piloto',
        ]);

        foreach ($questions as $question) {
            $export->push([
                'nro' => $question->pivot->position, // @phpstan-ignore-line
                'clave' => $question->answer,
                'tipo de item' => $question->tags()->where('tag_group_id', 1)->first()?->name ?? 'n/a',
                'eje' => $question->tags()->where('tag_group_id', 2)->first()?->name ?? 'n/a',
                'contenido' => $question->tags()->where('tag_group_id', 3)->first()?->name ?? 'n/a',
                'habilidad' => $question->tags()->where('tag_group_id', 4)->first()?->name ?? 'n/a',
                'piloto' => 'No',
            ]);
        }

        return $export;
    }
}
