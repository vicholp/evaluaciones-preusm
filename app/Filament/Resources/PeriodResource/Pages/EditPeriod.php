<?php

namespace App\Filament\Resources\PeriodResource\Pages;

use App\Filament\Resources\PeriodResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriod extends EditRecord
{
    protected static string $resource = PeriodResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
