<?php

namespace App\Imports\Sheets;

use App\Models\Questionnaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class QuestionnaireStatsImport implements /*ShouldQueue,*/ OnEachRow, HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow
{
    private $questionnaire_id;

    public function __construct(int $questionnaire_id)
    {
        $this->questionnaire_id = $questionnaire_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        Questionnaire::find($this->questionnaire_id)->fill([
            'id' => $this->questionnaire_id,

            'average' => $this->toFloat($row['promedio_de_los_primeros_intentos']),
            'standart_deviation' => $this->toFloat($row['desviacion_estandar_para_intentos_con_mejores_calificaciones']),
            'skewness' => $this->replaceDecimal($row['asimetria_de_la_distribucion_de_puntuaciones_para_intentos_con_mejores_calificaciones']),
            'kurtosis' => $this->replaceDecimal($row['curtosis_de_la_distribucion_de_puntuaciones_para_intentos_con_mejores_calificaciones']),
            'coefficient_internal_consistency' => $this->toFloat($row['coeficiente_de_consistentia_interna_para_intentos_con_mejores_calificaciones']),
            'error_ratio' => $this->toFloat($row['ratio_de_error_para_intentos_con_mejores_calificaciones']),
            'standard_error' => $this->toFloat($row['error_estandar_para_intentos_con_mejores_calificaciones']),
        ])->save();
    }

    private function toFloat($string)
    {
        if ($string == '') return 0;

        return Str::replace(',','.', Str::replace('%', '', $string)) / 100;
    }

    private function replaceDecimal($string)
    {
        if ($string == '') return 0;

        return Str::replace(',','.', $string);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
