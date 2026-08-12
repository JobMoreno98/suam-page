<?php

namespace App\Filament\Resources\AreaFormacions\Pages;

use App\Filament\Resources\AreaFormacions\AreaFormacionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateAreaFormacion extends CreateRecord
{
    protected static string $resource = AreaFormacionResource::class;
    public function getTitle(): string|Htmlable
    {
        return "Crear Área de Formación";
    }
}
