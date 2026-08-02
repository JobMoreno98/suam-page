<?php

namespace App\Filament\Widgets;

use App\Models\MaterialGrupo;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DesgloseRecursosTable extends TableWidget
{
    // Ajusta el ancho para que ocupe todo el espacio en pantallas grandes
    protected int | string | array $columnSpan = 'full';

    // Título de la tabla en el Dashboard
    protected static ?string $heading = 'Desglose de Recursos por Curso y Convocatoria';

    // Orden de aparición (3 para que salga debajo de los stats y la gráfica)
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Consultamos el modelo que une Cursos y Convocatorias, y contamos sus materiales
                MaterialGrupo::query()
                    ->with(['curso', 'convocatoria'])
                    ->withCount('items') // Asegúrate de tener la relación materiales() en MaterialesGrupo
            )
            ->defaultSort('items_count', 'desc') // Ordenamos por los que tienen más recursos
            ->columns([
                TextColumn::make('curso.nombre')
                    ->label('Curso')
                    ->searchable()
                    ->sortable()
                    ->wrap(), // Útil por si los nombres de los cursos son muy largos

                TextColumn::make('convocatoria.nombre')
                    ->label('Convocatoria')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Total de Recursos')
                    ->sortable()
                    ->badge()
                    ->color(fn(int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 5 => 'warning',
                        default => 'success',
                    }),
            ])->filters([
                SelectFilter::make('convocatoria_id')
                    ->label('Filtrar por Convocatoria')
                    ->relationship('convocatoria', 'nombre')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('curso_id')
                    ->label('Filtrar por Curso')
                    ->relationship('curso', 'nombre')
                    ->searchable()
                    ->preload(),
            ])
            // Paginar los resultados para no saturar el inicio
            ->paginated([5, 10, 25]);
    }
}
