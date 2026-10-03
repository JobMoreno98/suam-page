<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Convocatoria;
use Carbon\Carbon;

class CursoController extends Controller
{
    public function index()
    {
        $categorias = AreaFormacion::with(['cursos' => function ($query) {
            $query->where('ofertado', true);
        }])
            ->orderBy('orden')->where('activo', true)
            ->get();
        return view('cursos.index', compact('categorias'));
    }
    public function show(Curso $curso)
    {
        $hoy = Carbon::today();

        // Buscamos si existe al menos una convocatoria general donde hoy esté dentro del rango
        $convocatoriaActiva = Convocatoria::where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->latest()
            ->first();

        return view('cursos.show', compact('curso', 'convocatoriaActiva'));
    }
}
