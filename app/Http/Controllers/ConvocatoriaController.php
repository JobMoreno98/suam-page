<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    public function index()
    {
        $convocatorias = Convocatoria::latest()->get();

        return view('convocatorias.index', compact('convocatorias'));
    }
    public function show(Convocatoria $convocatoria)
    {
        return view('convocatorias.show', compact('convocatoria'));
    }
}
