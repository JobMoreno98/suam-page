<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Galeria extends Model
{
    /** @use HasFactory<\Database\Factories\GaleriaFactory> */
    use HasFactory;
    protected $fillable = ['titulo', 'slug', 'descripcion', 'activa', 'orden'];

    protected $casts = [
        'activa' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model->titulo);
        });

        static::updating(function ($model) {
            // Solo regenera el slug si el nombre cambió
            if ($model->isDirty('titulo')) {
                $model->slug = static::generateUniqueSlug($model->titulo, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $titulo, $ignoreId = null): string
    {
        $slug = Str::slug($titulo);
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


    public function imagenes(): HasMany
    {
        return $this->hasMany(GaleriaImagen::class)->orderBy('orden');
    }

    public function portada(): ?GaleriaImagen
    {
        return $this->imagenes->first();
    }
}
