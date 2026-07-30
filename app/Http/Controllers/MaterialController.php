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
            'area',
            'gruposMateriales.convocatoria',
            'gruposMateriales.items' => fn($q) => $q->orderBy('orden')
        ]);

        $gruposPorConvocatoria = $curso->gruposMateriales->groupBy('convocatoria_id');

        return view('recursos.show', compact('curso', 'gruposPorConvocatoria'));
    }
}
