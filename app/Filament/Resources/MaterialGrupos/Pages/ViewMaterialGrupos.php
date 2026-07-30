<?php

namespace App\Filament\Resources\MaterialGrupos\Pages;

use App\Filament\Resources\MaterialGrupos\MaterialGruposResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterialGrupos extends ViewRecord
{
    protected static string $resource = MaterialGruposResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
