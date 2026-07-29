<?php

namespace App\Filament\Resources\Banners\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('imagen')->disk('public')
                    ->directory('banner'),
                TextInput::make('nombre'),
                TinyEditor::make('contenido')->maxLength(500)->profile('default')->columnSpanFull()
            ]);
    }
}
