<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condicion extends Model
{
    use SoftDeletes;
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
