<?php

namespace App\Filament\Resources\Publicacions;

use App\Filament\Resources\Publicacions\Pages\CreatePublicacion;
use App\Filament\Resources\Publicacions\Pages\EditPublicacion;
use App\Filament\Resources\Publicacions\Pages\ListPublicacions;
use App\Filament\Resources\Publicacions\Pages\ViewPublicacion;
use App\Filament\Resources\Publicacions\Schemas\PublicacionForm;
use App\Filament\Resources\Publicacions\Schemas\PublicacionInfolist;
use App\Filament\Resources\Publicacions\Tables\PublicacionsTable;
use App\Models\Publicacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PublicacionResource extends Resource
{
    protected static ?string $model = Publicacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'Publicaciones';

    protected static ?string $title = 'Publicaciones';
    protected static ?string $navigationLabel = 'Publicaciones';
    protected static ?string $pluralModelLabel = 'Publicaciones';

    protected static string | UnitEnum | null $navigationGroup = 'Difusión';

    public static function form(Schema $schema): Schema
    {
        return PublicacionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PublicacionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublicacionsTable::configure($table);
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
            'index' => ListPublicacions::route('/'),
            'create' => CreatePublicacion::route('/create'),
            'view' => ViewPublicacion::route('/{record}'),
            'edit' => EditPublicacion::route('/{record}/edit'),
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
