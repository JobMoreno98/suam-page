<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\MaterialGrupo;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $cursosPorArea = Curso::has('gruposMateriales')
            ->with(['area'])
            ->withCount('gruposMateriales')
            ->get()
            ->groupBy(fn($curso) => $curso->area?->nombre ?? 'Otras Áreas / General');

        return view('recursos.index', compact('cursosPorArea'));
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
