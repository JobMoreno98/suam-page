<?php

namespace App\Filament\Widgets;

use App\Models\AreaFormacion;
use App\Models\Convocatoria;
use App\Models\Curso;
use App\Models\Material;
use App\Models\Sede;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 1;

    // 2. Opcional: Como el widget ocupará la mitad, le decimos a sus 6 tarjetitas 
    // internas que se acomoden en 2 columnas (3 filas de 2) para que no se apachurren.
    protected int | array | null $columns = 2;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            // 1. Banners
            /*Stat::make('Banners Activos', Banner::count())
                ->description('Banners en carrusel')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),*/

            // 2. Convocatorias
            Stat::make('Convocatorias', Convocatoria::count())
                ->description('Convocatorias registradas')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            // 3. Cursos
            Stat::make('Cursos', Curso::count())
                ->description('Total de cursos')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
/*
            // 4. Sedes
            Stat::make('Sedes', Sede::count())
                ->description('Sedes y planteles')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('danger'),
*/
            // 5. Áreas de Formación
            Stat::make('Áreas de Formación', AreaFormacion::count())
                ->description('Categorías académicas')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('primary'),

            // 6. Recursos
            Stat::make('Recursos', Material::count())
                ->description('Materiales didácticos')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('success'),
        ];
    }
}
