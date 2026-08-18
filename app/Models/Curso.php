<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Curso extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    public function area(): BelongsTo
    {
        return $this->belongsTo(AreaFormacion::class, 'area_id');
    }
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
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => strip_tags($this->descripcion),
            'modalidad' => $this->modalidad,
        ];
    }
    public function gruposMateriales(): HasMany
    {
        return $this->hasMany(MaterialGrupo::class, 'curso_id');
    }
    protected function modalidadFormateada(): Attribute
    {
        return Attribute::make(
            get: function () {
                $mod = strtolower($this->modalidad ?? 'presencial');

                return $mod === 'ambas' ? 'Presencial / Virtual' : ucfirst($mod);
            }
        );
    }

}
