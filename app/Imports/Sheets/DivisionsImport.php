<?php

namespace App\Imports\Sheets;

use App\Models\Division;
use App\Models\Period;
use App\Models\StudyPlan;
use App\Models\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class DivisionsImport implements ToModel, /*ShouldQueue,*/ HasReferencesToOtherSheets, WithBatchInserts, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithUpserts, WithValidation
{
    public function __construct(
        private Period $period
    ) {
        //
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $subject = Subject::whereName($row['subject'])->firstOrFail();
            $studyPlan = StudyPlan::whereName($row['study_plan'])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return new Division([
            'name' => $row['name'],
            'subject_id' => $subject->id,
            'period_id' => $this->period->id,
            'study_plan_id' => $studyPlan->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'subject' => 'bail|required|exists:subjects,name',
            'study_plan' => 'bail|required|exists:study_plans,name',
        ];
        ;
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
        return 'id';
    }
}
