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
                FileUpload::make('archivos')                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                        'application/vnd.ms-powerpoint',
                                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                        'application/zip',
                                        'application/x-rar-compressed',
                                        'text/plain',
                                    ])
                    ->label('Archivos')
                    ->multiple()->disk('public')
                    ->directory('publicaciones-archivos')
                    ->columnSpanFull()->panelLayout('grid')
                    ->reorderable() // <- Esto activa el arrastrar y soltar para ordenar
                    ->appendFiles(),
            ]);
    }
}
