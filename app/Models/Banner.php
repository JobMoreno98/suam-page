<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function getUrlImagenAttribute()
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : 'suam.jpg';
    }
    protected $appends = ['url_imagen'];
}
