<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'numero_cuenta'; // indica cual es la llave primaria
    public $incrementing = false; // desactiva autoincremento
    protected $keyType = 'string'; // indica que la llave no es entero 

    protected $fillable = [
        'numero_cuenta',
        'nombre',
        'a_paterno',
        'a_materno',
        'creditos',
        'semestre',
        'regularidad',
        'carrera_id',
    ];

    protected $casts = [
        'regularidad' => 'boolean',
    ];

    /**
     * Relación Muchos a Muchos con Materias.
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'alumno_materia', 'alumno_numero_cuenta', 'materia_id')
            ->withTimestamps();
    }

    /**
     * Relación Muchos a Muchos con Condiciones.
     */
    public function condiciones(): BelongsToMany
    {
        return $this->belongsToMany(Condicion::class, 'alumno_condicion', 'alumno_numero_cuenta', 'condicion_id')
            ->withTimestamps();
    }

    /**
     * Relación con la Carrera a la que pertenece el alumno (solo una a la vez).
     */
    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    /**
     * Valida si el alumno puede inscribir una materia dada la regla de negocio:
     * El alumno puede inscribir materias de su propia carrera, o de carreras distintas siempre y cuando sean optativas.
     */
    public function puedeInscribirMateria(Materia $materia): bool
    {
        if ($this->carrera_id === $materia->carrera_id) {
            return true;
        }

        return $materia->esOptativa();
    }
}
