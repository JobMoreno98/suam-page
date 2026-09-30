<?php

namespace App\Filament\Resources\AreaFormacions\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

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
                Toggle::make('activo')
                    ->onColor('success')
                    ->offColor('danger')->inline(false),
                TinyEditor::make('descripcion')->columnSpanFull()->profile('minimal')

            ])->columns(4);
    }
}
