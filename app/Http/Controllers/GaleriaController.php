<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriaController extends Controller
{
    public function index(Request $request): View
    {
        $galerias = Galeria::query()
            ->where('activa', true)
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where('titulo', 'like', '%' . $request->input('buscar') . '%')
            )
            ->withCount('imagenes')
            ->with(['imagenes' => fn ($q) => $q->orderBy('orden')->limit(1)])
            ->orderBy('orden')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('galerias.index', compact('galerias'));
    }

    public function show(Galeria $galeria): View
    {
        abort_unless($galeria->activa, 404);

        $galeria->load('imagenes');

        $relacionadas = Galeria::query()
            ->where('activa', true)
            ->where('id', '!=', $galeria->id)
            ->withCount('imagenes')
            ->with(['imagenes' => fn ($q) => $q->orderBy('orden')->limit(1)])
            ->latest()
            ->limit(3)
            ->get();

        return view('galerias.show', compact('galeria', 'relacionadas'));
    }
}