<?php

namespace App\Imports\Sheets;

use App\Models\Student;
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

class StudentsImport implements /*ShouldQueue,*/ HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, OnEachRow, WithValidation
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        DB::transaction(function() use($row){
            $user = User::updateOrCreate([
                'email' => $row['email'],
            ],[
                'name' => $row['name'],
                'rut' => $row['rut'],
                'password' => $row['rut'],
            ]);

            Student::firstOrCreate([
                'user_id' => $user->id,
            ],[
                'uuid' => Student::getUniqueUuid(),
            ]);
        });
    }

    public function rules(): array
    {
        return [
            'id' => 'bail|nullable|exists:users,id',
            'name' => 'bail|required|string',
            'rut' => 'bail|required|string',
            'email' => 'bail|required|email',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
