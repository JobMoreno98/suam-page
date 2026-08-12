<?php

namespace App\Filament\Resources\Publicacions\Pages;

use App\Filament\Resources\Publicacions\PublicacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublicacions extends ListRecords
{
    protected static string $resource = PublicacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
