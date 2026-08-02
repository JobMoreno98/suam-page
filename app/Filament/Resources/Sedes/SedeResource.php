<?php

namespace App\Filament\Resources\Sedes;

use App\Filament\Resources\Sedes\Pages\CreateSede;
use App\Filament\Resources\Sedes\Pages\EditSede;
use App\Filament\Resources\Sedes\Pages\ListSedes;
use App\Filament\Resources\Sedes\Pages\ViewSede;
use App\Filament\Resources\Sedes\Schemas\SedeForm;
use App\Filament\Resources\Sedes\Schemas\SedeInfolist;
use App\Filament\Resources\Sedes\Tables\SedesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SedeResource extends Resource
{
    protected static ?string $model = Sede::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'Sedes';

    public static function form(Schema $schema): Schema
    {
        return SedeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SedeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SedesTable::configure($table);
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
            'index' => ListSedes::route('/'),
            'create' => CreateSede::route('/create'),
            'view' => ViewSede::route('/{record}'),
            'edit' => EditSede::route('/{record}/edit'),
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
