<?php

namespace App\Filament\Resources\Galerias\Pages;

use App\Filament\Resources\Galerias\GaleriaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGaleria extends EditRecord
{
    protected static string $resource = GaleriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
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
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['imagenes_temp'] = $this->record
            ->imagenes()
            ->orderBy('orden')
            ->pluck('ruta')
            ->toArray();

        return $data;
    }
}
