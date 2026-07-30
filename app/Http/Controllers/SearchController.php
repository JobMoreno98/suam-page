<?php
namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Convocatoria;
use App\Models\Curso;
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

        // 2. Buscamos en Cursos (aprovechando getRouteKeyName() para la URL)
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

        // 4. Buscamos en Recursos/Materiales
        // Carga ansiosa (with) para obtener el curso y generar la ruta sin consultas extra N+1
        $materiales = Material::search($query)
            ->get()
            ->load('grupo.curso')
            ->map(function ($item) {
                $item->tipo_resultado = 'Recurso';
                $curso = $item->grupo?->curso;
                
                // Redirige al acordeón de recursos del curso al que pertenece este material
                $item->url_resultado = $curso ? route('recursos.show', $curso) : '#';
                return $item;
            });

        // 5. Combinamos todas las colecciones
        $todosLosResultados = $areas
            ->concat($cursos)
            ->concat($convocatorias)
            ->concat($materiales);

        // 6. Paginamos manualmente la colección combinada
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