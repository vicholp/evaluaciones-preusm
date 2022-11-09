<?php

namespace App\Imports\Sheets;

use App\Models\Question;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements /*ShouldQueue,*/ ToModel, HasReferencesToOtherSheets, WithBatchInserts, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithUpserts, WithValidation
{
    private $questionnaire_id;

    public function __construct(int $questionnaire_id)
    {
        $this->questionnaire_id = $questionnaire_id;
    }

    public function model(array $row)
    {
        $row['indice_de_facilidad'] = $row['indice_de_facilidad'] ?? null;
        $row['desviacion_estandar'] = $row['desviacion_estandar'] ?? null;
        $row['calificacion_aleatoria_estimada'] = $row['calificacion_aleatoria_estimada'] ?? null;
        $row['ponderacion_deseada'] = $row['ponderacion_deseada'] ?? null;
        $row['peso_efectivo'] = $row['peso_efectivo'] ?? null;
        $row['indice_de_discriminacion'] = $row['indice_de_discriminacion'] ?? null;
        $row['eficiencia_discriminativa'] = $row['eficiencia_discriminativa'] ?? null;

        return new Question([
            'questionnaire_id' => $this->questionnaire_id,
            'name' => $row['nombre_de_la_pregunta'],
            'position' => $row['q'],

            'facility_index' => $this->toFloat($row['indice_de_facilidad']),
            'standart_deviation' => $this->toFloat($row['desviacion_estandar']),
            'random_guess_score' => $this->toFloat($row['calificacion_aleatoria_estimada']),
            'intended_weight' => $this->toFloat($row['ponderacion_deseada']),
            'effective_weight' => $this->toFloat($row['peso_efectivo']),
            'discrimination_index' => $this->toFloat($row['indice_de_discriminacion']),
            'discrimination_efficiency' => $this->toFloat($row['eficiencia_discriminativa']),
        ]);
    }

    private function toFloat($string)
    {
        if ($string == '') return 0;

        return Str::replace(',','.', Str::replace('%', '', $string)) / 100;
    }

    public function rules(): array
    {
        return [
            'nombre_de_la_pregunta' => 'required|string',
            'q' => 'required|integer',

            'indice_de_facilidad' => 'nullable|string',
            'desviacion_estandar' => 'nullable|string',
            'calificacion_aleatoria_estimada' => 'nullable|string',
            'ponderacion_deseada' => 'nullable|string',
            'peso_efectivo' => 'nullable|string',
            'indice_de_discriminacion' => 'nullable|string',
            'eficiencia_discriminativa' => 'nullable|string',
        ];;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return ['questionnaire_id', 'position'];
    }

}
