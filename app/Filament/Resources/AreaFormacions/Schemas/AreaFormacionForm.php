<?php

namespace App\Filament\Resources\AreaFormacions\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AreaFormacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre'),
                ColorPicker::make('color')
                    ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                TextInput::make('orden')->numeric()->required()->minValue(1),
                TinyEditor::make('descripcion')->columnSpanFull()->profile('minimal')

            ])->columns(3);
    }
}
