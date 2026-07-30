<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        // Carga las categorías/áreas con sus respectivos cursos
        $categorias = AreaFormacion::with(['cursos'])->get();

        return view('cursos.index', compact('categorias'));
    }
}
