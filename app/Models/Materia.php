<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Materia extends Model
{
    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'semestre',
        'tipo',
        'plan_trabajo_id',
        'carrera_id',
    ];

    /**
     * Relación 1 a 1 con Plan de Trabajo.
     */
    public function planTrabajo(): BelongsTo
    {
        return $this->belongsTo(PlanTrabajo::class, 'plan_trabajo_id');
    }

    /**
     * Relación con la Carrera a la que pertenece la materia.
     */
    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    /**
     * Relación Muchos a Muchos con Alumnos inscritos.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumno_materia', 'materia_id', 'alumno_numero_cuenta')
            ->withTimestamps();
    }

    /**
     * Determina si la materia es de tipo optativa.
     */
    public function esOptativa(): bool
    {
        return str_contains(mb_strtolower($this->tipo), 'optativa');
    }
}
