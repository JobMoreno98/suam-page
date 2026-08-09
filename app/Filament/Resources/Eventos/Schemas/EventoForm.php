<?php

namespace App\Filament\Resources\Eventos\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('imagen')->disk('public')->image()->columnSpanFull()->label('Portada')->required()
                    ->directory('banner')->alignCenter(),
                TextInput::make('nombre')->columnSpanFull(),
                TinyEditor::make('contenido')->profile('default')->columnSpanFull(),
                FileUpload::make('galeria')
                    ->label('Galería de Imágenes')
                    ->multiple()->disk('public')
                    ->directory('galerias-eventos')
                    ->image()->columnSpanFull()->panelLayout('grid')
                    ->reorderable() // <- Esto activa el arrastrar y soltar para ordenar
                    ->appendFiles(),
            ]);
    }
}
