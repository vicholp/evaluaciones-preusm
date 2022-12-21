<?php

namespace App\Filament\Resources\QuestionnaireResource\Pages;

use App\Filament\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use Filament\Resources\Pages\Page;

class UploadQuestionnaireResults extends Page
{
    protected static string $resource = QuestionnaireResource::class;

    protected static string $view = 'filament.resources.questionnaire-resource.pages.upload-questionnaire-results';

    public Questionnaire $questionnaire;

    public function mount(int $record): void
    {
        $this->questionnaire = Questionnaire::findOrFail($record);
    }
}
