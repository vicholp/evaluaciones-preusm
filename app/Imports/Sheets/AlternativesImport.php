<?php

namespace App\Imports\Sheets;

use App\Models\Alternative;
use App\Models\Questionnaire;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AlternativesImport implements /* ShouldQueue, */ ToModel, HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithUpserts
{
    use RemembersRowNumber;

    private $questionnaire_id;
    private $index;

    public function __construct(int $questionnaire_id, int $index)
    {
        $this->questionnaire_id = $questionnaire_id;
        $this->index = $index;
    }

    public function model(array $row)
    {
        $position = $this->getRowNumber() - 1;
        $question = Questionnaire::find($this->questionnaire_id)->questions()->wherePosition($this->index)->first();

        if ($row['respuesta_modelo'] == '[Sin respuesta]') {
            Alternative::firstOrCreate([
                'question_id' => $question->id,
                'position' => 0,
                'name' => 'N/A',
                'correct' => false,
                'data' => 'No answer',
            ]);

            return;
        }

        return new Alternative([
            'question_id' => $question->id,
            'position' => $position,
            'name' => Str::substr($row['respuesta_modelo'], 0, 1),
            'correct' => $row['credito_parcial'] == '100,00%',
            'data' => null,
        ]);
    }

    private function toFloat($string)
    {
        return Str::replace(',', '.', Str::replace('%', '', $string)) / 100;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return ['question_id', 'position'];
    }
}
