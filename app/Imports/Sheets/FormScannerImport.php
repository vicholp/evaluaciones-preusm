<?php

namespace App\Imports\Sheets;

use App\Models\Questionnaire;
use App\Models\User;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class FormScannerImport implements OnEachRow, WithHeadingRow, WithValidation
{
    private Questionnaire $questionnaire;

    public const QUESTION_COLUMN = 'respuestas';
    public const RUT_COLUMN = 'idid_';

    public function __construct(int $questionnaire_id)
    {
        $this->questionnaire = Questionnaire::findOrFail($questionnaire_id);
    }

    public function onRow(Row $row): void
    {
        $row = $row->toArray();

        $rut = $this->getRut($row);

        $student = User::whereRut($rut)->first();

        if ($student == null) {
            return;
        }

        $student = $student->student;

        if ($student == null) {
            return;
        }

        $questions_count = $this->questionnaire->questions()->count();

        DB::transaction(function () use ($row, $student, $questions_count) {
            for ($i = 0; $i < $questions_count; ++$i) {
                $column_name = self::QUESTION_COLUMN.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);

                $marked = $row[$column_name];

                if ($marked == null) {
                    try {
                        $student->alternatives()->attach($this->questionnaire->questions()->wherePosition($i + 1)->first()->alternatives()->whereName('N/A')->first());
                    } catch (QueryException $e) {
                        //
                    }
                    continue;
                }

                $question = $this->questionnaire->questions()->wherePosition($i + 1)->first();
                $alternative = $question->alternatives()->whereName($marked)->first();
                try {
                    $student->alternatives()->attach($alternative->id);
                } catch (ErrorException $e) {
                    //
                }
            }
        });
    }

    private function getRut(array $row): string
    {
        $rut = '';

        for ($i = 1; $i <= 8; ++$i) {
            $column_name = self::RUT_COLUMN.str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            $rut .= $row[$column_name];
        }

        return $rut;
    }

    public function rules(): array
    {
        $question_count = 80;
        $validations = [];

        for ($i = 1; $i <= $question_count; ++$i) {
            $validations[self::QUESTION_COLUMN.str_pad((string) $i, 2, '0', STR_PAD_LEFT)] = 'nullable|string';
        }

        return array_merge($validations, [
            'file_name' => 'required|string',

            'idid_01' => 'required|integer',
            'idid_02' => 'required|integer',
            'idid_03' => 'required|integer',
            'idid_04' => 'required|integer',
            'idid_05' => 'required|integer',
            'idid_06' => 'required|integer',
            'idid_07' => 'required|integer',
            'idid_08' => 'required|integer',
            'idid_dv' => 'required|alphanum',
        ]);
    }
}
