<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Publicacion extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    protected $casts = [
        'archivos' => 'array'
    ];
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->nombre);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->nombre);
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => strip_tags($this->descripcion), // Limpiamos el HTML para el índice
        ];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
