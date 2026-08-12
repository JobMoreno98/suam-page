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
