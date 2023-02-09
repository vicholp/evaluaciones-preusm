<?php

namespace App\Imports\Sheets;

use App\Models\Alternative;
use App\Models\Questionnaire;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Row;

class DefaultAlternativesImport implements /* ShouldQueue, */ OnEachRow, HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithEvents
{
    use RemembersRowNumber;
    use RegistersEventListeners;

    private $questionnaire_id;
    private $index;
    private $position_to_name = [
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D',
        5 => 'E',
    ];

    public static function afterSheet(AfterSheet $event)
    {
        $questionnaire_id = $event->getConcernable()->questionnaire_id;
        $index = $event->getConcernable()->index;

        $question = Questionnaire::find($questionnaire_id)->questions()->wherePosition($index)->first();

        Alternative::firstOrCreate([
            'question_id' => $question->id,
            'position' => -1,
            'name' => 'right',
            'correct' => true,
            'data' => 'correct',
        ]);

        Alternative::firstOrCreate([
            'question_id' => $question->id,
            'position' => -2,
            'name' => 'wrong',
            'correct' => false,
            'data' => 'wrong',
        ]);
    }

    public function __construct(int $questionnaire_id, int $index)
    {
        $this->questionnaire_id = $questionnaire_id;
        $this->index = $index;
    }

    public function onRow(Row $row)
    {
        $position = $row->getIndex() - 1;
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

        Alternative::firstOrCreate([
            'question_id' => $question->id,
            'position' => $position,
            'name' => $this->position_to_name[$position],
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
}
