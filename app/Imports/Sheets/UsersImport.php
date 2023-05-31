<?php

namespace App\Imports\Sheets;

use App\Models\User;
use App\Rules\ValidRut;
use App\Utils\Rut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class UsersImport implements HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, OnEachRow, WithValidation, WithEvents
{
    use RegistersEventListeners;

    public function __construct(
        public string $role,
    ) {
        //
    }

    public function onRow(Row $row): void
    {
        $row = $row->toArray();

        DB::transaction(function () use ($row) {
            $rut = Rut::fromString($row['rut']);

            $user = User::updateOrCreate([
                'rut' => $rut->getRut(),
            ], [
                'email' => $row['email'],
                'name' => $row['name'],
                'rut_dv' => $rut->getDv(),
                'password' => Hash::make($row['password'] ?? $rut->__toString()),
            ]);

            $user->role()->assign($this->role);
        });
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'rut' => ['required', 'string', new ValidRut()],
            'password' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
