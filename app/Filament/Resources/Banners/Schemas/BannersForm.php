<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/webp',
                    ])
                    ->disk('public')
                    ->directory('banners')
                    ->openable()
                    ->columnSpanFull(),
                TextInput::make('nombre')->label('Nombre'),
                Toggle::make('is_active')->inline(false)->label('Mostrar')->default(true),

            ]);
    }
}
