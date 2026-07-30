<?php
namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Convocatoria;
use App\Models\Curso;
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

        // 1. Buscamos en cada modelo
        $areas = AreaFormacion::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Área de Formación';
            $item->url_resultado = route('areas.show', $item);
            return $item;
        });

        $cursos = Curso::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Curso';
            $item->url_resultado = route('cursos.show', $item->slug);
            return $item;
        });

        $convocatorias = Convocatoria::search($query)->get()->map(function ($item) {
            $item->tipo_resultado = 'Convocatoria';
            $item->url_resultado = route('convocatorias.show', $item);
            return $item;
        });

        // 2. Combinamos todas las colecciones
        $todosLosResultados = $areas->concat($cursos)->concat($convocatorias);

        // 3. Paginamos manualmente la colección combinada
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