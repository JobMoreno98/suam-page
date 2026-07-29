<?php

namespace App\Filament\Resources\AreaFormacions;

use App\Filament\Resources\AreaFormacions\Pages\CreateAreaFormacion;
use App\Filament\Resources\AreaFormacions\Pages\EditAreaFormacion;
use App\Filament\Resources\AreaFormacions\Pages\ListAreaFormacions;
use App\Filament\Resources\AreaFormacions\Pages\ViewAreaFormacion;
use App\Filament\Resources\AreaFormacions\Schemas\AreaFormacionForm;
use App\Filament\Resources\AreaFormacions\Schemas\AreaFormacionInfolist;
use App\Filament\Resources\AreaFormacions\Tables\AreaFormacionsTable;
use App\Models\AreaFormacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AreaFormacionResource extends Resource
{
    protected static ?string $model = AreaFormacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Área de Formación';

    public static function form(Schema $schema): Schema
    {
        return AreaFormacionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AreaFormacionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AreaFormacionsTable::configure($table);
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
            'index' => ListAreaFormacions::route('/'),
            'create' => CreateAreaFormacion::route('/create'),
            'view' => ViewAreaFormacion::route('/{record}'),
            'edit' => EditAreaFormacion::route('/{record}/edit'),
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
