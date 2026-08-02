<?php

namespace App\Filament\Widgets;

use App\Models\Convocatoria;
use Filament\Widgets\ChartWidget;

class MaterialesPorConvocatoriaChart extends ChartWidget
{
    protected ?string $heading = 'Materiales Por Convocatoria';

    // Título que aparecerá arriba de la gráfica

    // Orden de aparición en el Dashboard (después de las tarjetas de estadísticas)
    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Traemos todas las convocatorias y contamos sus materiales usando la relación que creamos
        $convocatorias = Convocatoria::withCount('gruposMateriales')->get();
        //dd($convocatorias);

        // Extraemos las etiquetas (nombres de las convocatorias)
        // Si no tiene 'nombre', usamos un texto por defecto o su 'periodo'
        $labels = $convocatorias->map(function ($convocatoria) {
            return $convocatoria->nombre ?? ('Convocatoria ' . $convocatoria->periodo);
        })->toArray();

        // Extraemos los conteos (valores para la gráfica)
        $data = $convocatorias->pluck('grupos_materiales_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total de Materiales',
                    'data' => $data,
                    // Puedes usar colores hexadecimales o rgb para que combine con tu brandgreen/navy
                    'backgroundColor' => '#10b981', // Emerald 500 (similar a tu brandgreen)
                    'borderColor' => '#047857',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
