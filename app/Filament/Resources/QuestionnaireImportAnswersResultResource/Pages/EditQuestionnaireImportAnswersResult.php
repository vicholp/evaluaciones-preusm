<?php

namespace App\Filament\Resources\QuestionnaireImportAnswersResultResource\Pages;

use App\Filament\Resources\QuestionnaireImportAnswersResultResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestionnaireImportAnswersResult extends EditRecord
{
    protected static string $resource = QuestionnaireImportAnswersResultResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
