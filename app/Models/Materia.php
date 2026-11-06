<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'semestre',
        'tipo',
        'plan_trabajo_id',
        'carrera_id',
    ];

    public function planTrabajo(): BelongsTo
    {
        return $this->belongsTo(PlanTrabajo::class, 'plan_trabajo_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumno_materia', 'materia_id', 'alumno_numero_cuenta')
            ->withTimestamps();
    }

    public function esOptativa(): bool
    {
        return str_contains(mb_strtolower($this->tipo), 'optativa');
    }
}
