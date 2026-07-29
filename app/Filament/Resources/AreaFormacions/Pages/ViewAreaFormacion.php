<?php

namespace App\Filament\Resources\AreaFormacions\Pages;

use App\Filament\Resources\AreaFormacions\AreaFormacionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAreaFormacion extends ViewRecord
{
    protected static string $resource = AreaFormacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
