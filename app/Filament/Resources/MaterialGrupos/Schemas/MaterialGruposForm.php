<?php

namespace App\Filament\Resources\MaterialGrupos\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\Convocatoria;
use App\Models\Curso;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class MaterialGruposForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Información General')
                    ->schema([
                        TextInput::make('titulo_grupo')
                            ->label('Título')->required()
                            ->placeholder('Ej. Material Didáctico - Unidad 1')
                            ->maxLength(150),

                        Select::make('curso_id')
                            ->label('Curso')
                            ->options(Curso::pluck('nombre', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->exists('cursos', 'id'), // Valida que el curso exista en la BD

                        Select::make('convocatoria_id')
                            ->label('Convocatoria')
                            ->options(Convocatoria::pluck('nombre', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->exists('convocatorias', 'id'), // Valida que la convocatoria exista en la BD
                    ])->columns(3)->columnSpanFull(),

                Section::make('Recursos y Contenidos')
                    ->description('Añade todos los archivos, enlaces o videos que pertenezcan a este grupo.')
                    ->schema([

                        Repeater::make('items')
                            ->relationship('items')
                            ->minItems(1) // Obliga a ingresar al menos 1 material
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('titulo')
                                            ->label('Título del Recurso')
                                            ->placeholder('Ej. Manual PDF, Video explicativo')
                                            ->required()
                                            ->minLength(3)
                                            ->maxLength(150),

                                        Select::make('tipo')
                                            ->label('Tipo de Recurso')
                                            ->options([
                                                'archivo' => 'Documento',
                                                'imagen'  => 'Imagen',
                                                'youtube' => 'Video de YouTube',
                                                'enlace'  => 'Enlace Web',
                                                'texto'   => 'Texto / Indicaciones',
                                            ])
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('imagen_val', null);
                                                $set('archivo_val', null);
                                                $set('url_val', null);
                                                $set('texto_val', null);
                                                $set('valor', null);
                                            }),
                                    ]),

                                // 1. VALIDACIÓN DE ARCHIVOS E IMÁGENES
                                // 1. COMPONENTE EXCLUSIVO PARA IMÁGENES
                                FileUpload::make('imagen_val')
                                    ->label('Subir Imagen')
                                    ->directory('materiales/imagenes')->disk('public')
                                    ->multiple()
                                    ->reorderable() // Permite cambiar el orden de los archivos arrastrándolos
                                    ->appendFiles() // Mantiene los archivos anteriores al añadir nuevos
                                    ->formatStateUsing(function ($state, $record) {
                                        if ($record && $record->tipo === 'imagen') { // o 'archivo'
                                            $valor = $record->valor;

                                            if (is_array($valor)) {
                                                return $valor;
                                            }

                                            // Si por alguna razón había un string guardado previamente
                                            return filled($valor) ? [$valor] : [];
                                        }

                                        return $state;
                                    })
                                    ->image()
                                    ->preserveFilenames()
                                    ->visible(fn(Get $get) => $get('tipo') === 'imagen')
                                    ->formatStateUsing(fn($state, $record) => ($record && $record->tipo === 'imagen') ? $record->valor : $state)
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('valor', $state))
                                    ->required(fn(Get $get) => $get('tipo') === 'imagen')
                                    ->maxSize(20480)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->columnSpanFull(),

                                // 2. COMPONENTE EXCLUSIVO PARA ARCHIVOS / DOCUMENTOS
                                FileUpload::make('archivo_val')
                                    ->label('Subir Archivo / Documento')
                                    ->directory('materiales/archivos')->disk('public')
                                    ->multiple()->openable()
                                    ->reorderable() // Permite cambiar el orden de los archivos arrastrándolos
                                    ->appendFiles() // Mantiene los archivos anteriores al añadir nuevos
                                    ->formatStateUsing(function ($state, $record) {
                                        if ($record && $record->tipo === 'archivo') { // o 'archivo'
                                            $valor = $record->valor;

                                            if (is_array($valor)) {
                                                return $valor;
                                            }

                                            // Si por alguna razón había un string guardado previamente
                                            return filled($valor) ? [$valor] : [];
                                        }

                                        return $state;
                                    })
                                    ->preserveFilenames()
                                    ->visible(fn(Get $get) => $get('tipo') === 'archivo')
                                    ->formatStateUsing(fn($state, $record) => ($record && $record->tipo === 'archivo') ? $record->valor : $state)
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('valor', $state))
                                    ->required(fn(Get $get) => $get('tipo') === 'archivo')
                                    ->maxSize(20480)
                                    ->acceptedFileTypes([
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
                                    ->columnSpanFull(),
                                // 2. VALIDACIÓN DE ENLACES / YOUTUBE
                                TextInput::make('url_val')
                                    ->label(fn(Get $get) => $get('tipo') === 'youtube' ? 'URL de YouTube' : 'Enlace Web')
                                    ->placeholder(fn(Get $get) => $get('tipo') === 'youtube' ? 'https://www.youtube.com/watch?v=...' : 'https://ejemplo.com')
                                    ->url()
                                    ->visible(fn(Get $get) => in_array($get('tipo'), ['youtube', 'enlace']))
                                    ->formatStateUsing(fn($state, $record) => ($record && in_array($record->tipo, ['youtube', 'enlace'])) ? $record->valor : $state)
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('valor', $state))
                                    ->required(fn(Get $get) => in_array($get('tipo'), ['youtube', 'enlace']))
                                    ->rules([
                                        fn(Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                            if ($get('tipo') === 'youtube' && $value) {
                                                // Regex flexible que soporta: www, music, m, youtu.be y parámetros URL (&si=, &t=, etc.)
                                                $pattern = '/^(https?:\/\/)?((www|music|m)\.)?(youtube\.com|youtu\.be)\/.+$/i';

                                                if (!preg_match($pattern, $value)) {
                                                    $fail('Debe ser una URL válida de YouTube o YouTube Music.');
                                                }
                                            }
                                        },
                                    ])
                                    ->columnSpanFull(),

                                // 3. VALIDACIÓN DE TEXTO ENRIQUECIDO
                                TinyEditor::make('texto_val')
                                    ->label('Texto / Instrucciones')
                                    ->visible(fn(Get $get) => $get('tipo') === 'texto')
                                    ->formatStateUsing(fn($state, $record) => ($record && $record->tipo === 'texto') ? $record->valor : $state)
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('valor', $state))
                                    ->required(fn(Get $get) => $get('tipo') === 'texto')
                                    ->columnSpanFull(),

                                // CAMPO REAL OCULTO QUE GUARDA EN LA BASE DE DATOS
                                Hidden::make('valor')
                                    ->required(function (Get $get) {
                                        // Es requerido siempre que haya seleccionado un tipo
                                        return filled($get('tipo'));
                                    }),

                            ])
                            ->itemLabel(fn(array $state): ?string => $state['titulo'] ?? 'Nuevo Recurso')
                            ->collapsible()
                            ->cloneable()
                            ->grid(2)
                            ->orderColumn('orden')
                            ->addActionLabel('+ Añadir otro recurso a este registro')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ]);
    }
}
