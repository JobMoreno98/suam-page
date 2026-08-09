<?php

namespace App\Filament\Resources\Convocatorias\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConvocatoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('imagen')->label('Cartel')->disk('public') ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->directory('convocatorias'),
                TextInput::make('nombre')->required(),
                Section::make('Fechas')
                    ->description('Fechas necesarias para la convocatoria')
                    ->schema([
                        DatePicker::make('fecha_inicio')->required()->label('Fecha de inicio convocatoria'),
                        DatePicker::make('fecha_fin')->required()->label('Fecha de cierre convocatoria'),
                        DatePicker::make('fecha_registro')->required()->date()->label('Fecha de inicio de cursos'),
                    ])->columns(3)->columnSpanFull(),

                TinyEditor::make('contenido')->required()->columnSpanFull(),

            ]);
    }
}
