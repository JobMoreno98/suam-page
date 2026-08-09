<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSitio extends Model
{
    protected $guarded = [];
    protected $casts = [
        'codigo_etica' => 'array',
        'contacto' => 'array',
    ];
}
