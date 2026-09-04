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
        $rutas = array_values($this->data['imagenes_temp'] ?? []);

        // Borra las que ya no están en el array (y su archivo físico)
        $this->record->imagenes()
            ->whereNotIn('ruta', $rutas)
            ->get()
            ->each(function ($imagen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagen->ruta);
                $imagen->delete();
            });

        $existentes = $this->record->imagenes()->pluck('ruta')->toArray();

        foreach ($rutas as $orden => $ruta) {
            if (in_array($ruta, $existentes)) {
                $this->record->imagenes()->where('ruta', $ruta)->update(['orden' => $orden]);
            } else {
                $this->record->imagenes()->create([
                    'ruta' => $ruta,
                    'orden' => $orden,
                ]);
            }
        }
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $rutas = $this->record
            ->imagenes()
            ->orderBy('orden')
            ->pluck('ruta')
            ->toArray();

        // FileUpload necesita claves únicas (no índices 0,1,2...) para
        // poder renderizar correctamente archivos ya existentes.
        $data['imagenes_temp'] = collect($rutas)
            ->mapWithKeys(fn($ruta) => [(string) \Illuminate\Support\Str::uuid() => $ruta])
            ->toArray();

        return $data;
    }
}