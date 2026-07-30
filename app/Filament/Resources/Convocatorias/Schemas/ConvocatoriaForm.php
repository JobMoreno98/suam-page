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
                FileUpload::make('imagen')->label('Cartel')->disk('public')
                    ->directory('convocatorias'),
                TextInput::make('nombre')->required(),
                Section::make('Fechas')
                    ->description('Fechas necesarias para la convocatoria')
                    ->schema([
                        DatePicker::make('fecha_inicio')->required(),
                        DatePicker::make('fecha_fin')->required(),
                        DatePicker::make('fecha_registro')->required(),
                    ])->columns(3)->columnSpanFull(),

                TinyEditor::make('contenido')->required()->columnSpanFull(),

            ]);
    }
}
