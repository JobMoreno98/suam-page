<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Evento extends Model
{

    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    protected $casts = [
        'galeria' => 'array',
    ];
    protected $appends = ['url_imagen', 'enlace'];
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->nombre);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->nombre);
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlImagenAttribute()
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : 'suam.jpg';
    }
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'contenido' => strip_tags($this->descripcion), // Limpiamos el HTML para el índice
        ];
    }

    protected function enlace(): Attribute
    {
        return Attribute::make(
            get: fn() => route('eventos.show', $this->slug), // O $this->id si usas IDs
        );
    }
}
