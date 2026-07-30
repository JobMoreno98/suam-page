<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function grupo()
    {
        return $this->belongsTo(MaterialGrupo::class, 'material_grupo_id');
    }
    
}
