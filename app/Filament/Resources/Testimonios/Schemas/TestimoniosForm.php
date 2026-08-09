<?php

namespace App\Filament\Resources\Testimonios\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TestimoniosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')->required()->label('Título'),
                TextInput::make('nombre_alumno')->required()->label('Nombre Alumno'),
                TinyEditor::make('contenido')->profile('simple')->required()->columnSpanFull(),
                FileUpload::make('galeria')->multiple()->acceptedFileTypes(['image/*', 'video/*'])->disk('public')->directory('testimonios')
                    ->maxSize(51200) // 50 MB (50 * 1024)
                    ->rules([
                        'nullable',
                        'file',
                    ])->panelLayout('grid')->reorderable()->columnSpanFull()
            ])->columns(2);
    }
}
