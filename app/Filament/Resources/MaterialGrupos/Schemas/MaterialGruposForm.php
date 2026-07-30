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

                // SECCIÓN 1: SELECCIÓN INDEPENDIENTE DE CURSO Y CONVOCATORIA
                Section::make('Información General')
                    ->schema([

                        TextInput::make('titulo_grupo')
                            ->label('Identificador / Título del Bloque')
                            ->placeholder('Ej. Material Didáctico - Unidad 1'),

                        Select::make('curso_id')
                            ->label('Curso')
                            ->options(Curso::pluck('nombre', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('convocatoria_id')
                            ->label('Convocatoria')
                            ->options(Convocatoria::pluck('nombre', 'id')) // Muestra todas las convocatorias sin filtrar
                            ->searchable()
                            ->preload()
                            ->required(),

                    ])->columns(3)->columnSpanFull(),

                // SECCIÓN 2: REPEATER PARA AÑADIR MÚLTIPLES ELEMENTOS AL MISMO TIEMPO
                Section::make('Recursos y Contenidos')
                    ->description('Añade todos los archivos, enlaces o videos que pertenezcan a este grupo.')
                    ->schema([

                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('titulo')
                                            ->label('Título del Recurso')
                                            ->placeholder('Ej. Manual PDF, Video explicativo')
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('tipo')
                                            ->label('Tipo de Recurso')
                                            ->options([
                                                'archivo' => '📄 Archivo / Documento',
                                                'imagen'  => '🖼️ Imagen',
                                                'youtube' => '🎥 Video de YouTube',
                                                'enlace'  => '🔗 Enlace Web',
                                                'texto'   => '📝 Texto / Indicaciones',
                                            ])
                                            ->required()
                                            ->live()
                                            // Si cambian el tipo en edición, limpiamos los campos
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('archivo_path', null);
                                                $set('url_link', null);
                                                $set('texto_contenido', null);
                                            }),
                                    ]),

                                // 1. ARCHIVOS / IMÁGENES -> Guarda en 'archivo_path'
                                FileUpload::make('archivo_path')
                                    ->label(fn(Get $get) => $get('tipo') === 'imagen' ? 'Subir Imagen' : 'Subir Archivo')
                                    ->directory(fn(Get $get) => $get('tipo') === 'imagen' ? 'materiales/imagenes' : 'materiales/archivos')
                                    ->image(fn(Get $get) => $get('tipo') === 'imagen')
                                    ->preserveFilenames()
                                    ->visible(fn(Get $get) => in_array($get('tipo'), ['archivo', 'imagen']))
                                    ->dehydrated(false) // No intenta guardar directamente esta clave en la BD
                                    ->live()
                                    ->columnSpanFull(),

                                // 2. YOUTUBE / ENLACE WEB
                                TextInput::make('url_link')
                                    ->label(fn(Get $get) => $get('tipo') === 'youtube' ? 'URL de YouTube' : 'Enlace Web')
                                    ->placeholder(fn(Get $get) => $get('tipo') === 'youtube' ? 'https://www.youtube.com/watch?v=...' : 'https://ejemplo.com')
                                    ->url()
                                    ->visible(fn(Get $get) => in_array($get('tipo'), ['youtube', 'enlace']))
                                    ->dehydrated(false) // No intenta guardar directamente esta clave en la BD
                                    ->live()
                                    ->columnSpanFull(),

                                // 3. TEXTO
                                TinyEditor::make('texto_contenido')
                                    ->label('Texto / Instrucciones')
                                    ->visible(fn(Get $get) => $get('tipo') === 'texto')
                                    ->dehydrated(false) // No intenta guardar directamente esta clave en la BD
                                    ->live()
                                    ->columnSpanFull(),

                                // CAMPO OCULTO REAL QUE SE GUARDA EN LA BASE DE DATOS
                                Hidden::make('valor')
                                    ->dehydrateStateUsing(function (Get $get) {
                                        $tipo = $get('tipo');
                                        return match ($tipo) {
                                            'archivo', 'imagen' => $get('archivo_path'),
                                            'youtube', 'enlace' => $get('url_link'),
                                            'texto'             => $get('texto_contenido'),
                                            default             => null,
                                        };
                                    })
                                    ->required(),
                            ])
                            ->itemLabel(fn(array $state): ?string => $state['titulo'] ?? 'Nuevo Recurso')
                            ->collapsible()
                            ->cloneable()->grid(2)
                            ->orderColumn('orden')
                            ->addActionLabel('+ Añadir otro recurso a este registro')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ]);
    }
}
