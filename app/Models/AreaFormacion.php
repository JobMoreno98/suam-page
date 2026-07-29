<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class AreaFormacion extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'id', 'area_id');
    }
}
