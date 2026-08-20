<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BannersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()->imageEditor() // Activa el editor de imágenes
                    ->imageEditorAspectRatioOptions([
                        '3.08:1',
                        null,
                    ])
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/webp',
                    ])
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                        $filename = Str::random(40) . '.webp';
                        $path = 'banners/' . $filename;

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
                    ->disk('public')
                    ->directory('banners')
                    ->openable()
                    ->columnSpanFull(),
                TextInput::make('nombre')->label('Nombre'),
                Toggle::make('is_active')->inline(false)->label('Mostrar')->default(true),

            ]);
    }
}
