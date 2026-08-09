<?php

namespace App\Filament\Resources\Convocatorias;

use App\Filament\Resources\Convocatorias\Pages\CreateConvocatoria;
use App\Filament\Resources\Convocatorias\Pages\EditConvocatoria;
use App\Filament\Resources\Convocatorias\Pages\ListConvocatorias;
use App\Filament\Resources\Convocatorias\Pages\ViewConvocatoria;
use App\Filament\Resources\Convocatorias\Schemas\ConvocatoriaForm;
use App\Filament\Resources\Convocatorias\Schemas\ConvocatoriaInfolist;
use App\Filament\Resources\Convocatorias\Tables\ConvocatoriasTable;
use App\Models\Convocatoria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ConvocatoriaResource extends Resource
{
    protected static ?string $model = Convocatoria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $recordTitleAttribute = 'Convocatorias';

    protected static string | UnitEnum | null $navigationGroup = 'Difusión';
    public static function form(Schema $schema): Schema
    {
        return ConvocatoriaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConvocatoriaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConvocatoriasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConvocatorias::route('/'),
            'create' => CreateConvocatoria::route('/create'),
            'view' => ViewConvocatoria::route('/{record}'),
            'edit' => EditConvocatoria::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
