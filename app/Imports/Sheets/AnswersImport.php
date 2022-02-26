<?php

namespace App\Imports\Sheets;

use App\Models\User;
use App\Models\Student;
use Maatwebsite\Excel\Row;
use App\Models\Questionnaire;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class AnswersImport implements /*ShouldQueue,*/ HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, OnEachRow
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
        if ($student == null) return;
        $student = $student->student;

        DB::transaction(function() use($row, $questions, $student, $count){
            for($i = 0; $i < $count; $i++){
                $name = 'respuesta_'.($i+1);
                if ($row[$name] == '-') continue;
                $question = Questionnaire::find($this->questionnaire_id)->questions()->wherePosition($i+1)->first();
                $alternative = $question->alternatives()->whereName($row[$name])->first();
                try{
                    $student->alternatives()->attach($alternative->id);
                }catch(QueryException $e){
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
