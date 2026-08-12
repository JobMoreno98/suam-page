<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::query()
            ->latest()
            ->paginate(9);

        return view('publicaciones.index', compact('publicaciones'));
    }

    public function show(Publicacion $publicacion)
    {
        return view('publicaciones.show', compact('publicacion'));
    }
}
