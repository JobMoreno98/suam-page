<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Convocatoria;
use App\Models\Curso;
use App\Models\Evento; // <-- 1. Importamos el modelo Evento
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q'));
        $page = $request->input('page', 1);
        $perPage = 10;

        if (empty($query)) {
            return view('search.index', [
                'query' => '',
                'resultados' => new LengthAwarePaginator([], 0, $perPage),
            ]);
        }

        // 1. Buscamos en Áreas de Formación
        $areas = AreaFormacion::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Área de Formación';
            $item->url_resultado = route('areas.show', $item);
            return $item;
        });

        // 2. Buscamos en Cursos
        $cursos = Curso::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Curso';
            $item->url_resultado = route('cursos.show', $item);
            return $item;
        });

        // 3. Buscamos en Convocatorias
        $convocatorias = Convocatoria::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Convocatoria';
            $item->url_resultado = route('convocatorias.show', $item);
            return $item;
        });

        // 4. Buscamos en Eventos (NUEVO BLOQUE)
        $eventos = Evento::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Evento';
            $item->url_resultado = route('eventos.show', $item);
            return $item;
        });

        // 5. Buscamos en Recursos/Materiales
        // 5. Buscamos en Recursos/Materiales
        $materiales = Material::search($query)
            ->query(function ($builder) use ($query) {
                // Le decimos a la base de datos que busque también dentro de la relación
                $builder->orWhereHas('grupo.curso', function ($q) use ($query) {
                    $q->where('nombre', 'LIKE', '%' . $query . '%');
                });
            })
            ->get()
            ->load('grupo.curso')
            ->map(function ($item) {
                $item->tipo_resultado = 'Recurso';
                $curso = $item->grupo?->curso;

                $item->url_resultado = $curso ? route('recursos.show', $curso) : '#';
                return $item;
            });

        // 6. Combinamos todas las colecciones (añadiendo $eventos)
        $todosLosResultados = $areas
            ->concat($cursos)
            ->concat($convocatorias)
            ->concat($eventos) // <-- 2. Concatenamos los eventos
            ->concat($materiales);

        // 7. Paginamos manualmente
        $resultadosPaginados = new LengthAwarePaginator(
            $todosLosResultados->forPage($page, $perPage)->values(),
            $todosLosResultados->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('search.index', [
            'query' => $query,
            'resultados' => $resultadosPaginados
        ]);
    }
}
