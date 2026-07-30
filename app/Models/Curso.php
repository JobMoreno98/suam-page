<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;


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
}
