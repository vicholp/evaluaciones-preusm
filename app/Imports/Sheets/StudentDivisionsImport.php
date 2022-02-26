<?php

namespace App\Imports\Sheets;

use App\Models\Period;
use App\Models\User;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class StudentDivisionsImport implements /*ShouldQueue,*/ HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, OnEachRow, WithValidation
{
    private $periodId;

    public function __construct(int $periodId)
    {
        $this->periodId = $periodId;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $subjects = array_values(array_slice($row,1));

        Validator::make($subjects, [
            '*' => 'nullable|exists:divisions,name',
        ])->validate();

        DB::transaction(function() use($row, $subjects){
            $student = User::whereEmail($row['email'])->first()->student;
            $n_subjects = count($subjects);

            for($i = 0; $i < $n_subjects; $i++) {
                $name = $subjects[$i];

                if ($name === null) continue;

                $division = Period::find($this->periodId)->divisions()->whereName($name)->first();

                $student->divisions()->attach($division);
            }
        });
    }

    public function rules(): array
    {
        return [
            'email' => 'bail|required|email',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
