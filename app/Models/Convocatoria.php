<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Convocatoria extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $guarded = [];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_registro' => 'date',
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

    public function getRangoFechasAttribute(): string
    {
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return 'Fecha por definir';
        }

        // Establece el idioma de Carbon a Español
        $inicio = $this->fecha_inicio->locale('es');
        $fin = $this->fecha_fin->locale('es');

        // Caso 1: Mismo mes y mismo año (Ej: "Del 10 al 14 de agosto de 2026")
        if ($inicio->format('Y-m') === $fin->format('Y-m')) {
            return sprintf(
                'Del %d al %d de %s de %s',
                $inicio->day,
                $fin->day,
                $fin->translatedFormat('F'),
                $fin->year
            );
        }

        // Caso 2: Diferente mes, mismo año (Ej: "Del 28 de julio al 5 de agosto de 2026")
        if ($inicio->year === $fin->year) {
            return sprintf(
                'Del %d de %s al %d de %s de %s',
                $inicio->day,
                $inicio->translatedFormat('F'),
                $fin->day,
                $fin->translatedFormat('F'),
                $fin->year
            );
        }

        // Caso 3: Diferente año (Ej: "Del 15 de diciembre de 2025 al 10 de enero de 2026")
        return sprintf(
            'Del %d de %s de %s al %d de %s de %s',
            $inicio->day,
            $inicio->translatedFormat('F'),
            $inicio->year,
            $fin->day,
            $fin->translatedFormat('F'),
            $fin->year
        );
    }
    public function getEstadoInscripcionAttribute(): array
    {
        // Carbon::today() maneja sólo la fecha (sin horas/minutos) para comparaciones exactas
        $hoy = Carbon::today();

        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return [
                'texto' => 'Por definir',
                'badge' => 'bg-gray-100 text-gray-600 border-gray-200',
                'estado' => 'indefinido'
            ];
        }

        // 1. PRÓXIMA: La fecha actual aún no llega a la fecha de inicio
        if ($hoy->lt($this->fecha_inicio)) {
            return [
                'texto' => 'Próximamente',
                'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                'estado' => 'proxima'
            ];
        }

        // 2. VENCIDA: La fecha actual ya pasó la fecha de fin
        if ($hoy->gt($this->fecha_fin)) {
            return [
                'texto' => 'Inscripciones cerradas',
                'badge' => 'bg-red-50 text-red-700 border-red-200',
                'estado' => 'vencida'
            ];
        }

        // 3. ABIERTA: La fecha actual está dentro del rango (inicio <= hoy <= fin)
        return [
            'texto' => 'Inscripciones abiertas',
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'estado' => 'abierta'
        ];
    }
    public function getUrlImagenAttribute()
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : 'suam.jpg';
    }
    public function getFechaRegistroFormateadaAttribute(): string
    {
        return $this->fecha_registro
            ? $this->fecha_registro->translatedFormat('j \d\e F \d\e Y')
            : 'Por definir';
    }
}
