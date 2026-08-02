<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        // Ordenamos los eventos por los más recientes y los paginamos (ej. 9 por página)
        $eventos = Evento::latest()->paginate(9);

        return view('eventos.index', compact('eventos'));
    }

    /**
     * Muestra el detalle de un evento específico.
     * Laravel busca automáticamente el evento por su ID o Slug gracias al binding.
     */
    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }
}
