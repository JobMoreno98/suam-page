<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialGrupo extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::class);
    }

    public function items()
    {
        return $this->hasMany(Material::class, 'material_grupo_id')->orderBy('orden');
    }
}
