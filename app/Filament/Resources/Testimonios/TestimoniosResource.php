<?php

namespace App\Filament\Resources\Testimonios;

use App\Filament\Resources\Testimonios\Pages\CreateTestimonios;
use App\Filament\Resources\Testimonios\Pages\EditTestimonios;
use App\Filament\Resources\Testimonios\Pages\ListTestimonios;
use App\Filament\Resources\Testimonios\Pages\ViewTestimonios;
use App\Filament\Resources\Testimonios\Schemas\TestimoniosForm;
use App\Filament\Resources\Testimonios\Schemas\TestimoniosInfolist;
use App\Filament\Resources\Testimonios\Tables\TestimoniosTable;
use App\Models\Testimonio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TestimoniosResource extends Resource
{
    protected static ?string $model = Testimonio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Testimonio';
    protected static string | UnitEnum | null $navigationGroup = 'Difusión';
    
    public static function form(Schema $schema): Schema
    {
        return TestimoniosForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TestimoniosInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestimoniosTable::configure($table);
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
            'index' => ListTestimonios::route('/'),
            'create' => CreateTestimonios::route('/create'),
            'view' => ViewTestimonios::route('/{record}'),
            'edit' => EditTestimonios::route('/{record}/edit'),
        ];
    }
}
