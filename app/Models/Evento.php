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
            $model->slug = static::generateUniqueSlug($model->nombre);
        });

        static::updating(function ($model) {
            // Solo regenera el slug si el nombre cambió
            if ($model->isDirty('nombre')) {
                $model->slug = static::generateUniqueSlug($model->nombre, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $nombre, $ignoreId = null): string
    {
        $slug = Str::slug($nombre);
        $originalSlug = $slug;
        $count = 1;

        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;

            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
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
