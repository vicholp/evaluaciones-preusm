<?php

namespace App\Filament\Resources\QuestionnaireGroupResource\Pages;

use App\Filament\Resources\QuestionnaireGroupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestionnaireGroups extends ListRecords
{
    protected static string $resource = QuestionnaireGroupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
