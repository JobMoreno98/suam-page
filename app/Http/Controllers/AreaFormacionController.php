<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use Illuminate\Http\Request;

class AreaFormacionController extends Controller
{


    public function show(AreaFormacion $area_formacion)
    {
        // Cargamos los cursos del área con paginación
        $cursos = $area_formacion->cursos()->paginate(9);

        return view('areas.show', compact('area_formacion', 'cursos'));
    }
}
