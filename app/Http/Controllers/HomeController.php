<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Sede;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $sedes = Sede::select('id','nombre','logo','direccion','slug','telefono')->get()->take(3);
        $slides = Banner::orderBy('id')->get()->take(3);

        return view('home',compact('sedes','slides'));
        return $sedes;
    }
}
