<?php

namespace App\Filament\Resources\AreaFormacions\Pages;

use App\Filament\Resources\AreaFormacions\AreaFormacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAreaFormacions extends ListRecords
{
    protected static string $resource = AreaFormacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Añadir'),
        ];
    }
}
