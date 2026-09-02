<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GaleriaImagen extends Model
{
        protected $fillable = ['galeria_id', 'ruta', 'titulo', 'alt_text', 'orden'];

    public function galeria(): BelongsTo
    {
        return $this->belongsTo(Galeria::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->ruta);
    }
}
