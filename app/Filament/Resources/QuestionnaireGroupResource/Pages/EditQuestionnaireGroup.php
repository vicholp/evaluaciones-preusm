<?php

namespace App\Filament\Resources\QuestionnaireGroupResource\Pages;

use App\Filament\Resources\QuestionnaireGroupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestionnaireGroup extends EditRecord
{
    protected static string $resource = QuestionnaireGroupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
