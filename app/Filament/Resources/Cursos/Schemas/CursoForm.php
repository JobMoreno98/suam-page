<?php

namespace App\Filament\Resources\Cursos\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre'),
                Select::make('modaliad')->options([
                    'virtual' => 'Virtual',
                    'precencial' => 'Precencial',
                    'virtual/precencial' => 'Virtual / Precencial'
                ]),
                TinyEditor::make('descripcion')->label('Descripción')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default')
                    // Set RTL or use ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required()
            ]);
    }
}
