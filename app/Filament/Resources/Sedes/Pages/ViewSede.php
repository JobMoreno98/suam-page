<?php

namespace App\Filament\Resources\Sedes\Pages;

use App\Filament\Resources\Sedes\SedeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSede extends ViewRecord
{
    protected static string $resource = SedeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
