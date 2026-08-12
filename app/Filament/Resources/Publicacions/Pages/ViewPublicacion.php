<?php

namespace App\Filament\Resources\Publicacions\Pages;

use App\Filament\Resources\Publicacions\PublicacionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPublicacion extends ViewRecord
{
    protected static string $resource = PublicacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
