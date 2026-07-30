<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Banner;
use App\Models\Convocatoria;
use App\Models\Sede;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sedes = Sede::select('id', 'nombre', 'logo', 'direccion', 'slug', 'telefono')->get()->take(3);
        $slides = Banner::latest()->get()->take(3);

        $areas = AreaFormacion::all();

        $convocatorias = Convocatoria::latest()->get()->take(3);

        return view('home', compact('sedes', 'slides','areas','convocatorias'));
        return $sedes;
    }
}
