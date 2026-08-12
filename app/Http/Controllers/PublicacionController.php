<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index()
    {
        $articulos = Publicacion::query()
            ->latest()
            ->paginate(9);

        return view('publicaciones.index', compact('articulos'));
    }

    public function show(Publicacion $articulo)
    {
        return view('publicaciones.show', compact('articulo'));
    }
}
