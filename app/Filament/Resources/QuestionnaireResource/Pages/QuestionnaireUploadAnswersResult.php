<?php

namespace App\Filament\Resources\QuestionnaireResource\Pages;

use App\Filament\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireImportAnswersResult;
use Filament\Resources\Pages\Page;

class QuestionnaireUploadAnswersResult extends Page
{
    protected static string $resource = QuestionnaireResource::class;

    protected static string $view = 'filament.resources.questionnaire-resource.pages.questionnaire-upload-answers-result';

    public Questionnaire $questionnaire;
    public QuestionnaireImportAnswersResult $result;

    public function mount(int $record): void
    {
        $this->result = QuestionnaireImportAnswersResult::with(['childs' => function ($query) {
            $query->with(['childs'])->orderByDesc('updated_at');
        }])->findOrFail($this->result->id);

        $this->questionnaire = Questionnaire::findOrFail($record);
    }
}
