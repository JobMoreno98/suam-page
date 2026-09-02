<?php

namespace App\Filament\Resources\Galerias\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Storage;

class GaleriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->schema([
                        TextInput::make('titulo')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $state, callable $set) =>
                                $set('slug', Str::slug($state))
                            ),
                        Textarea::make('descripcion')
                            ->columnSpanFull(),
                        Toggle::make('activa')
                            ->default(true),
                    ])->columns(1),

                Section::make('Imágenes')
                    ->schema([
                        Repeater::make('imagenes')
                            ->relationship()
                            ->schema([
                                FileUpload::make('ruta')
                                    ->image()
                                    ->directory('galerias')->disk('public')->directory('galerias')
                                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                                        $filename = Str::random(40) . '.webp';
                                        $path = 'galerias/' . $filename;

                                        // Carga la imagen usando GD
                                        $sourceImage = imagecreatefromstring($file->get());

                                        // Convierte el espacio de color para evitar fondos negros en PNG transparentes
                                        imagepalettetotruecolor($sourceImage);
                                        imagealphablending($sourceImage, true);
                                        imagesavealpha($sourceImage, true);

                                        // Captura la imagen en buffer de memoria codificada como WebP al 80% de calidad
                                        ob_start();
                                        imagewebp($sourceImage, null, 80);
                                        $webpData = ob_get_clean();
                                        imagedestroy($sourceImage);

                                        // Guarda el archivo en el Storage
                                        Storage::disk('public')->put($path, $webpData);

                                        return $path;
                                    })
                                    ->imageEditor()
                                    ->required(),
                                TextInput::make('titulo'),
                                TextInput::make('alt_text')
                                    ->label('Texto alternativo'),
                            ])
                            ->columns(3)
                            ->reorderable('orden')
                            ->orderColumn('orden')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['titulo'] ?? 'Imagen')
                            ->defaultItems(0)
                            ->addActionLabel('Agregar imagen'),
                    ]),
            ])->columns(1);
    }
}
