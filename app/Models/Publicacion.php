<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

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
    public function toSearchableArray(): array
    {
        return [
            'nombre'    => $this->nombre,
            'slug'      => $this->slug,
            'contenido' => strip_tags($this->contenido),
        ];
    }
    protected function contenido(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Purifier::clean($value),
        );
    }
}
