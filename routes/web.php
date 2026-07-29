<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'home')->name('home');

Route::resource('sedes',SedeController::class)->names('sedes');

Route::get('/', [HomeController::class, 'index'])->name('home');
