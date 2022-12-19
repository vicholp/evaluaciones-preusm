<?php

namespace App\Filament\Resources\PeriodResource\Pages;

use App\Filament\Resources\PeriodResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPeriod extends ViewRecord
{
    protected static string $resource = PeriodResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
