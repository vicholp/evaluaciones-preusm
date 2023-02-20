<?php

namespace App\Imports;

use App\Imports\Sheets\AlternativesImport;
use App\Imports\Sheets\DefaultAlternativesImport;
use App\Imports\Sheets\QuestionnaireStatsImport;
use App\Imports\Sheets\QuestionsImport;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionnaireImport implements /* ShouldQueue, */ WithCalculatedFormulas, WithMultipleSheets, SkipsUnknownSheets
{
    private int $questionnaire_id;
    private bool $with_alternatives;

    public function __construct(int $questionnaire_id, bool $with_alternatives)
    {
        $this->questionnaire_id = $questionnaire_id;
        $this->with_alternatives = $with_alternatives;
    }

    public function sheets(): array
    {
        $sheets = [
            0 => new QuestionnaireStatsImport($this->questionnaire_id),
            1 => new QuestionsImport($this->questionnaire_id),
        ];

        if ($this->with_alternatives) {
            for ($i = 0; $i < 80; ++$i) {
                array_push($sheets, new AlternativesImport($this->questionnaire_id, $i + 1));
            }
        } else {
            for ($i = 0; $i < 80; ++$i) {
                array_push($sheets, new DefaultAlternativesImport($this->questionnaire_id, $i + 1));
            }
        }

        return $sheets;
    }

    public function onUnknownSheet($sheetName)
    {
        //
    }
}
