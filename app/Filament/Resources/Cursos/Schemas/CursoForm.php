<?php

namespace App\Filament\Resources\Cursos\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->description('Datos básicos del curso')
                    ->schema([
                        TextInput::make('nombre')
                            ->required()
                            ->columnSpan(2),

                        Select::make('area_id')
                            ->relationship('area', 'nombre')
                            ->label('Área')
                            ->required(),

                        Select::make('modalidad')
                            ->options([
                                'virtual' => 'Virtual',
                                'presencial' => 'Presencial',
                                'ambas' => 'Virtual / Presencial',
                            ])
                            ->required(),

                        TextInput::make('cupo')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100),

                        TextInput::make('duracion'),
                    ])
                    ->columns(4),

                Section::make('Horarios')
                    ->description('Agrega uno o más horarios para este curso')
                    ->schema([
                        Repeater::make('horarios') // Nombre exacto de tu columna JSON en la BD
                            ->label(false)
                            ->schema([
                                Select::make('modalidad')
                                    ->label('Modalidad')
                                    ->options([
                                        'presencial' => 'Presencial',
                                        'virtual' => 'Virtual',
                                    ])
                                    ->required(),

                                Select::make('dia_semana')
                                    ->label('Día de la semana')
                                    ->options([
                                        'lunes' => 'Lunes',
                                        'martes' => 'Martes',
                                        'miercoles' => 'Miércoles',
                                        'jueves' => 'Jueves',
                                        'viernes' => 'Viernes',
                                        'sabado' => 'Sábado',
                                        'domingo' => 'Domingo',
                                    ])
                                    ->required(),

                                TimePicker::make('hora_inicio')
                                    ->label('Hora de inicio')
                                    ->seconds(false)
                                    ->required(),

                                TimePicker::make('hora_fin')
                                    ->label('Hora de fin')
                                    ->seconds(false)
                                    ->required()
                                    ->after('hora_inicio'),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->addActionLabel('Agregar otro horario')
                            ->columnSpanFull(),
                    ]),

                Section::make('Contenido')
                    ->schema([
                        FileUpload::make('temario')
                            ->label('Temario')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ])
                            ->disk('public')
                            ->openable()
                            ->columnSpanFull(),

                        TinyEditor::make('descripcion')
                            ->label('Descripción')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default')
                            // ->direction('auto') // RTL/LTR si aplica
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ])
            ->columns(1); // las Sections ya manejan sus propias columnas internas
    }
}
