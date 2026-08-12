<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Testimonio extends Model
{
    use Searchable;
    protected $guarded = [];
    protected $casts = [
        'galeria' => 'array'
    ];
    protected function galeriaItems(): Attribute
    {
        $videoExtensions = ['mp4', 'mov', 'webm', 'avi', 'mkv'];

        return Attribute::make(
            get: fn() => collect($this->galeria ?? [])->map(fn($path) => [
                'tipo' => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $videoExtensions)
                    ? 'video' : 'imagen',
                'url' => Storage::disk('public')->url($path),
            ])->values(),
        );
    }
    // app/Models/Testimonio.php
    protected function primeraFoto(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->galeria_items->firstWhere('tipo', 'imagen')['url']
                ?? asset('img/logo.png'), // ajusta a tu placeholder real
        );
    }
}
