<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index(Request $request)
    {
        // Iniciar la consulta
        $query = Publicacion::query();

        if ($request->filled('year')) {
            $query->where('anio', $request->year);
        }

        // Obtener las publicaciones paginadas conservando los query params
        $publicaciones = $query->latest()->paginate(9)->withQueryString();
        //dd($publicaciones);

        // Obtener los años únicos de las publicaciones existentes para el sidebar
        $anios = Publicacion::select('anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        return view('publicaciones.index', compact('publicaciones', 'anios'));
    }

    public function show(Publicacion $publicacion)
    {
        return view('publicaciones.show', compact('publicacion'));
    }
}
