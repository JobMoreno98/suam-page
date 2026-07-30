<?php

namespace App\Filament\Resources\MaterialGrupos\Pages;

use App\Filament\Resources\MaterialGrupos\MaterialGruposResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialGrupos extends ListRecords
{
    protected static string $resource = MaterialGruposResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
