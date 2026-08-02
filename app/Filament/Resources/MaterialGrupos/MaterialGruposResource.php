<?php

namespace App\Filament\Resources\MaterialGrupos;

use App\Filament\Resources\MaterialGrupos\Pages\CreateMaterialGrupos;
use App\Filament\Resources\MaterialGrupos\Pages\EditMaterialGrupos;
use App\Filament\Resources\MaterialGrupos\Pages\ListMaterialGrupos;
use App\Filament\Resources\MaterialGrupos\Pages\ViewMaterialGrupos;
use App\Filament\Resources\MaterialGrupos\Schemas\MaterialGruposForm;
use App\Filament\Resources\MaterialGrupos\Schemas\MaterialGruposInfolist;
use App\Filament\Resources\MaterialGrupos\Tables\MaterialGruposTable;
use App\Models\MaterialGrupo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class MaterialGruposResource extends Resource
{
    protected static ?string $model = MaterialGrupo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $recordTitleAttribute = 'Recursos';


    protected static ?string $title = 'Recursos';
    protected static ?string $navigationLabel = 'Recursos';
    protected static ?string $pluralModelLabel = 'Recursos';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MaterialGruposForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaterialGruposInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialGruposTable::configure($table);
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
            'index' => ListMaterialGrupos::route('/'),
            'create' => CreateMaterialGrupos::route('/create'),
            'view' => ViewMaterialGrupos::route('/{record}'),
            'edit' => EditMaterialGrupos::route('/{record}/edit'),
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
