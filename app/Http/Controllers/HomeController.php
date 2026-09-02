<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Banner;
use App\Models\ConfiguracionSitio;
use App\Models\Convocatoria;
use App\Models\Evento;
use App\Models\Galeria;
use App\Models\Sede;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sedes = Sede::select('id', 'nombre', 'logo', 'direccion', 'slug', 'telefono')->get()->take(3);
        $slides = Banner::where('is_active', true)->get()->take(3);

        $areas = AreaFormacion::orderBy('orden')->get();

        $convocatorias = Convocatoria::latest()->get()->take(3);

        return view('home', compact('sedes', 'slides', 'areas', 'convocatorias'));
        return $sedes;
    }
    public function contacto()
    {
        return view('contacto');
    }

    public function acerca()
    {
        $configuracion = ConfiguracionSitio::select('acerca_de', 'dictamen')->first();
        return view('acerca', compact('configuracion'));
    }
    public function testimonios()
    {
        $testimonios = Testimonio::latest()->get();
        return view('testimonios.index', compact('testimonios'));
    }
    public function etica()
    {
        $configuracion = ConfiguracionSitio::first()->value('codigo_etica');
        return view('etica', compact('configuracion'));
    }

    public function galerias(){
        $galerias = Galeria::all();
        
    }
}
