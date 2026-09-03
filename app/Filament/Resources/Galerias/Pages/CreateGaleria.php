<?php

namespace App\Filament\Resources\Galerias\Pages;

use App\Filament\Resources\Galerias\GaleriaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGaleria extends CreateRecord
{
    protected static string $resource = GaleriaResource::class;
    protected function afterSave(): void
{
    $rutas = $this->data['imagenes_temp'] ?? [];

    foreach ($rutas as $orden => $ruta) {
        $this->record->imagenes()->create([
            'ruta' => $ruta,
            'orden' => $orden,
        ]);
    }
}
}
