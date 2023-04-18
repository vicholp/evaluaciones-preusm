<?php

namespace App\Imports\Sheets;

use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use App\Models\QuestionTag;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class TagQuestionsImport implements ShouldQueue, HasReferencesToOtherSheets, WithCalculatedFormulas, WithChunkReading, WithHeadingRow, WithValidation, OnEachRow
{
    private Questionnaire $questionnaire;
    private QuestionnaireImportAnswersResult $result;

    public function __construct(
        private int $questionnaireId,
        private int $resultId
    ) {
        //
    }

    public function onRow(Row $row): void
    {
        $this->questionnaire = Questionnaire::findOrFail($this->questionnaireId);
        $this->result = QuestionnaireImportAnswersResult::findOrFail($this->resultId);

        $row = $row->toArray();

        // $this->result->insertIntoLog('Processing question ' . $row['nro']);

        $question = $this->questionnaire->questions()->wherePosition($row['nro'])->firstOrFail();

        $question->tags()->delete();

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate([
                'name' => $row['eje'],
                'tag_group_id' => TagGroup::whereName('topic')->firstOrFail()->id,
            ])->id,
        ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate([
                'name' => $row['contenido'],
                'tag_group_id' => TagGroup::whereName('subtopic')->firstOrFail()->id,
            ])->id,
        ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate([
                'name' => $row['tipo_de_item'],
                'tag_group_id' => TagGroup::whereName('item_type')->firstOrFail()->id,
            ])->id,
        ]);

        QuestionTag::firstOrCreate([
            'question_id' => $question->id,
            'tag_id' => Tag::firstOrCreate([
                'name' => $row['habilidad'],
                'tag_group_id' => TagGroup::whereName('skill')->firstOrFail()->id,
            ])->id,
        ]);

        if (isset($row['piloto'])) {
            $question->pilot = $row['piloto'] === 'Si' ? true : false;
            $question->save();
        }

        $alternative = $question->alternatives()->whereName($row['clave'])->first();

        if ($alternative) {
            $alternative->correct = true;
            $alternative->save();
        } else {
            //
        }

        // $this->result->insertIntoLog('Question ' . $row['nro'] . ' processed');
    }

    public function rules(): array
    {
        return [
            'nro' => 'required|integer',
            'eje' => 'required|string',
            'clave' => 'required|string',
            'contenido' => 'required|string',
            'tipo_de_item' => 'required|string',
            'habilidad' => 'required|string',
            'piloto' => 'nullable|string|in:Si,No',
        ];
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
