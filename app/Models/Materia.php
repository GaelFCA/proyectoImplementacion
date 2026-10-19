<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function planTrabajo()
    {
        return $this->belongsTo(PlanTrabajo::class, 'plan_trabajo_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'materia_id');
    }
}