<?php

namespace App\Filament\Resources\QuestionnaireGroupResource\Pages;

use App\Filament\Resources\QuestionnaireGroupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestionnaireGroup extends ViewRecord
{
    protected static string $resource = QuestionnaireGroupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
