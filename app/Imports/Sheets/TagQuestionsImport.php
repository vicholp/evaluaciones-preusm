<?php

namespace App\Imports\Sheets;

use App\Models\Questionnaire;
use App\Models\QuestionTag;
use App\Models\Tag;
use App\Models\TagGroup;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class TagQuestionsImport implements /*ShouldQueue,*/ HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithValidation, OnEachRow
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

        $question = Questionnaire::find($this->questionnaire_id)->questions()->wherePosition($row['nro'])->first();

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate(
                [
                    'name' => $row['eje'],
                    'tag_group_id' => TagGroup::whereName('topic')->first()->id,
                ])->id,
            ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate(
                [
                    'name' => $row['contenido'],
                    'tag_group_id' => TagGroup::whereName('subtopic')->first()->id,
                ])->id,
            ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate(
                [
                    'name' => $row['tipo_de_item'],
                    'tag_group_id' => TagGroup::whereName('item_type')->first()->id,
                ])->id,
            ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate(
                [
                    'name' => $row['habilidad'],
                    'tag_group_id' => TagGroup::whereName('skill')->first()->id,
                ])->id,
            ]);
    }

    public function rules(): array
    {
        return [
            'nro' => 'required|integer',
            'eje' => 'required|string',
            'contenido' => 'required|string',
            'tipo_de_item' => 'required|string',
            'habilidad' => 'required|string',
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

    public function headingRow(): int
    {
        return 3;
    }
}
