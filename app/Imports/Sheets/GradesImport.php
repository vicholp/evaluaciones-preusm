<?php

namespace App\Imports\Sheets;

use App\Models\Questionnaire;
use App\Models\User;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class GradesImport implements /* ShouldQueue, */ HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, OnEachRow
{
    private $questionnaire_id;

    public function __construct(int $questionnaire_id)
    {
        $this->questionnaire_id = $questionnaire_id;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $questions = Questionnaire::find($this->questionnaire_id)->questions();
        $count = Questionnaire::find($this->questionnaire_id)->questions()->count();

        $student = User::whereEmail($row['direccion_de_correo'])->first();
        if ($student == null) {
            return;
        }
        $student = $student->student;

        DB::transaction(function () use ($row, $student, $count) {
            for ($i = 0; $i < $count; ++$i) {
                $name = array_keys($row)[$i + 8];
                $question = Questionnaire::find($this->questionnaire_id)->questions()->wherePosition($i + 1)->first();

                if ($row[$name] === '1,00') {
                    $alternative = $question->alternatives()->whereName('right')->first();
                } elseif ($row[$name] === '0,00') {
                    $alternative = $question->alternatives()->whereName('wrong')->first();
                } else {
                    $alternative = $question->alternatives()->whereName('N/A')->first();
                }

                try {
                    $student->alternatives()->attach($alternative->id);
                } catch (QueryException $e) {
                    //
                }
            }
        });
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
