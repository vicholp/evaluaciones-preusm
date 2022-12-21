<?php

namespace App\Filament\Resources\QuestionnaireResource\Pages;

use App\Filament\Resources\QuestionnaireResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestionnaire extends ViewRecord
{
    protected static string $resource = QuestionnaireResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('upload')
                ->url(QuestionnaireResource::getUrl('upload', $this->record)),
            // Action::make('upload-results')
            //     ->url(QuestionnaireResource::getUrl('upload-results', $this->record))
        ];
    }
}
