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
        return $this->hasMany(Curso::class, 'area_id', 'id');
    }
    
    public function getColorOscuroAttribute()
    {
        $hex = ltrim($this->color ?? '#3b82f6', '#');
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Reduce el brillo un 40%
        $r = max(0, min(255, $r * 0.6));
        $g = max(0, min(255, $g * 0.6));
        $b = max(0, min(255, $b * 0.6));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
