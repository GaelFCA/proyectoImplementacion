<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Condicion extends Model
{
    protected $table = 'condiciones';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación Muchos a Muchos con Alumnos que tienen esta condición.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumno_condicion', 'condicion_id', 'alumno_numero_cuenta')
            ->withTimestamps();
    }
}
