<?php

namespace App\Filament\Resources\AreaFormacions\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AreaFormacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre'),
                TinyEditor::make('descripcion')->columnSpanFull()->profile('minimal')
            ]);
    }
}
