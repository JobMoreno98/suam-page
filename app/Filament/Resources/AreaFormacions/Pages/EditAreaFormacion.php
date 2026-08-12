<?php

namespace App\Filament\Resources\AreaFormacions\Pages;

use App\Filament\Resources\AreaFormacions\AreaFormacionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditAreaFormacion extends EditRecord
{
    protected static string $resource = AreaFormacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            //DeleteAction::make(),
            //ForceDeleteAction::make(),
            //RestoreAction::make(),
        ];
    }
    public function getTitle(): string|Htmlable
    {
        $nombre = $this->record->nombre ?? 'Registro';
        return "Editar {$nombre}";
    }
}
