<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Sede extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    
    protected $casts = [
        'redes_sociales' => 'array',
        'correo' => 'array'
    ];
    protected $appends = ['url_logo'];
    
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

    public function getUrlLogoAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('img/logo.png');
    }
}
