<?php

use App\Http\Controllers\AreaFormacionController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'home')->name('home');

Route::resource('sedes', SedeController::class)->names('sedes');
Route::resource('cursos', CursoController::class)->names('cursos');
Route::resource('convocatorias', ConvocatoriaController::class)->names('convocatorias');
Route::resource('area-formacion', AreaFormacionController::class)->names('areas');

Route::resource('eventos', EventoController::class)->only(['index', 'show'])->names('eventos');


// Añadimos ->parameters() para forzar el parámetro 'curso'
Route::resource('recursos', MaterialController::class)
    ->parameters(['recursos' => 'curso'])
    ->names('recursos');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/acerca-de', [HomeController::class, 'acerca'])->name('home.acerca');
Route::get('/testimonios', [HomeController::class, 'testimonios'])->name('home.testimonios');

Route::get('/buscar', [SearchController::class, 'index'])->name('buscar');

Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');
