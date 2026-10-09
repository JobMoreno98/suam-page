<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use Illuminate\Http\Request;

class AreaFormacionController extends Controller
{


    public function show(AreaFormacion $area_formacion)
    {
        $cursosOfertados = $area_formacion->cursos()
            ->where('ofertado', true)
            ->orderBy('nombre')
            ->paginate(6, ['*'], 'ofertados_page');

        $cursosNoOfertados =  $area_formacion->cursos()
            ->where('ofertado', false)
            ->orderBy('nombre')
            ->paginate(6, ['*'], 'no_ofertados_page');

        return view('areas.show', compact('area_formacion', 'cursosOfertados', 'cursosNoOfertados'));
    }
}
