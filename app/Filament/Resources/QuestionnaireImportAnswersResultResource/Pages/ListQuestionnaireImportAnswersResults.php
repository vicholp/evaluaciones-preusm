<?php

namespace App\Filament\Resources\QuestionnaireImportAnswersResultResource\Pages;

use App\Filament\Resources\QuestionnaireImportAnswersResultResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestionnaireImportAnswersResults extends ListRecords
{
    protected static string $resource = QuestionnaireImportAnswersResultResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
