<?php

namespace App\Filament\Resources\MaterialGrupos\Pages;

use App\Filament\Resources\MaterialGrupos\MaterialGruposResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMaterialGrupos extends EditRecord
{
    protected static string $resource = MaterialGruposResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as &$item) {
                if (isset($item['tipo']) && isset($item['valor'])) {
                    if (in_array($item['tipo'], ['archivo', 'imagen'])) {
                        $item['archivo_path'] = $item['valor'];
                    } elseif (in_array($item['tipo'], ['youtube', 'enlace'])) {
                        $item['url_link'] = $item['valor'];
                    } elseif ($item['tipo'] === 'texto') {
                        $item['texto_contenido'] = $item['valor'];
                    }
                }
            }
        }

        return $data;
    }
}
