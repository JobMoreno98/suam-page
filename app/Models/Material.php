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
        $this->loadMissing('grupo.curso');

        return [
            'id'           => $this->id,
            'titulo'       => $this->titulo,
            'tipo'         => $this->tipo, // 'archivo', 'imagen', 'youtube', etc.
            'curso_nombre' => $this->grupo?->curso?->nombre,
        ];
    }
}
