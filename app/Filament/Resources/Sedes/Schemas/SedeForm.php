<?php

namespace App\Filament\Resources\Sedes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SedeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')->columnSpanFull()->alignCenter()->disk('public')
                    ->directory('logos')->imageEditor()->imageEditorAspectRatioOptions([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->visibility('public'),
                TextInput::make('nombre'),
                TextInput::make('centro_universitario'),
                TextInput::make('direccion')->label('Dirección'),
                TextInput::make('telefono')->label('Teléfono'),
                Repeater::make('correo')->schema([
                    TextInput::make('correo')->email()
                ])->itemLabel(fn(array $state): ?string => $state['correo'] ?? 'Sin nombre')->collapsible()->collapsed(),

                Repeater::make('redes_sociales')->schema([
                    Select::make('red')->options([
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter / X',
                        'youtube' => 'Youtube',
                        'instagram' => 'Instagram',
                        'web' => 'Página Web'
                    ]),
                    TextInput::make('enlace')->url()
                        ->suffixIcon(Heroicon::GlobeAlt)
                ])->columns(2)->itemLabel(fn(array $state): ?string => ucfirst($state['red']) ?? 'Sin nombre')->collapsible()->collapsed()
            ]);
    }
}
