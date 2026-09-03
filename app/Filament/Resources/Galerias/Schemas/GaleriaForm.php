<?php

namespace App\Filament\Resources\Galerias\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

                FileUpload::make('imagenes_temp')
                    ->label('Imágenes')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('galerias')
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                        $filename = Str::random(40) . '.webp';
                        $path = 'galerias/' . $filename;

                        $sourceImage = imagecreatefromstring($file->get());
                        imagepalettetotruecolor($sourceImage);
                        imagealphablending($sourceImage, true);
                        imagesavealpha($sourceImage, true);

                        ob_start();
                        imagewebp($sourceImage, null, 80);
                        $webpData = ob_get_clean();
                        imagedestroy($sourceImage);

                        Storage::disk('public')->put($path, $webpData);

                        return $path;
                    })->panelLayout('grid')
                    ->imageEditor()
                    ->dehydrated(false) // no lo intentes guardar directo en el modelo
                    ->required(),
            ])->columns(1);
    }
}
