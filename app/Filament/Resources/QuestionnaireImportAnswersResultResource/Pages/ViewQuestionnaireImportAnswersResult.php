<?php

namespace App\Filament\Resources\QuestionnaireImportAnswersResultResource\Pages;

use App\Filament\Resources\QuestionnaireImportAnswersResultResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestionnaireImportAnswersResult extends ViewRecord
{
    protected static string $resource = QuestionnaireImportAnswersResultResource::class;

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    protected function getActions(): array
    {
        return [
            //
        ];
    }
}
