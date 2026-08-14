<?php

namespace App\Filament\Resources\Cursos\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información')->schema([
                    TextInput::make('nombre')->required(),
                    Select::make('modalidad')->options([
                        'virtual' => 'Virtual',
                        'presencial' => 'Presencial',
                        'ambas' => 'Virtual / Presencial'
                    ])->required(),
                    Select::make('area_id')->relationship('area', 'nombre')->required(),
                    TextInput::make('cupo')->numeric()->minValue(1)
                        ->maxValue(100),

                    TimePicker::make('hora_inicio')
                        ->label('Hora de inicio')
                        ->required(),

                    TimePicker::make('hora_fin')
                        ->label('Hora de fin')
                        ->required()
                        ->after('hora_inicio'),
                    TextInput::make('duracion'),
                    FileUpload::make('temario')->acceptedFileTypes(['pdf', 'docs']),
                ])->columnSpanFull()->columns(4),

                TinyEditor::make('descripcion')->label('Descripción')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default')
                    // Set RTL or use ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required()
            ])->columns(3);
    }
}
