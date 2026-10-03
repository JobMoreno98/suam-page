<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\MaterialGrupo;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $cursosOfertados = Curso::has('gruposMateriales')
            ->where('ofertado', true)
            ->with('area')
            ->withCount('gruposMateriales')
            ->orderBy('nombre')
            ->paginate(6, ['*'], 'ofertados_page');

        $cursosNoOfertados = Curso::has('gruposMateriales')
            ->where('ofertado', false)
            ->with('area')
            ->withCount('gruposMateriales')
            ->orderBy('nombre')
            ->paginate(6, ['*'], 'no_ofertados_page');

        return view('recursos.index', compact('cursosOfertados', 'cursosNoOfertados'));
    }

    public function show(Curso $curso)
    {
        $curso->load([
            'area', // Asumo que cambiaste 'areaFormacion' a 'area' en tu relación
            // 'gruposMateriales.convocatoria', <-- Puedes quitar esto si ya no usas datos de la convocatoria
            'gruposMateriales.items' => fn($q) => $q->orderBy('orden')
        ]);

        // 1. Agrupamos por ciclo
        // 2. Cambiamos el nombre de la variable a $gruposPorCiclo
        $gruposPorCiclo = $curso->gruposMateriales->groupBy('ciclo');

        return view('recursos.show', compact('curso', 'gruposPorCiclo'));
    }
}
