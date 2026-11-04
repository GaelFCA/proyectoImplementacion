<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JefeCarrera extends Model
{
    protected $table = 'jefe_carreras'; // tabla a la que hace referencia
    protected $primaryKey = 'numero_trabajador'; // llave primaria no autoincremental
    public $incrementing = false; // desactiva autoincremento
    protected $keyType = 'string'; // indica que la llave no es entero 

    protected $fillable = [
        'numero_trabajador',
        'nombre',
        'a_paterno',
        'a_materno',
        'carrera_id',
    ];

    /**
     * Relación 1 a 1 con la Carrera que dirige.
     */
    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}
