<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Material extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    protected $casts = [
        'valor' => 'array',
    ];


    public function grupo()
    {
        return $this->belongsTo(MaterialGrupo::class, 'material_grupo_id');
    }
    public function toSearchableArray(): array
    {
        return [
            'id'     => $this->id,
            'titulo' => $this->titulo,
            'tipo'   => $this->tipo,
            // Eliminamos curso_nombre para que MySQL no colapse
        ];
    }
}
