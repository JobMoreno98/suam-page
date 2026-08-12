<?php

namespace App\Filament\Resources\Publicacions\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use PhpParser\Node\Stmt\Label;

class PublicacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('foto')->disk('public')->image()->columnSpanFull()->label('Portada')->required()
                    ->directory('publicaciones')->alignCenter(),
                TextInput::make('nombre')->columnSpanFull()->required()->Label('Título'),
                TinyEditor::make('contenido')->profile('default')->columnSpanFull()->required(),
                FileUpload::make('archivos')
                    ->label('Archivos')
                    ->multiple()->disk('public')
                    ->directory('publicaciones-archivos')
                    ->columnSpanFull()->panelLayout('grid')
                    ->reorderable() // <- Esto activa el arrastrar y soltar para ordenar
                    ->appendFiles(),
            ]);
    }
}
