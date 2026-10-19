<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrera extends Model
{
    protected $table = 'carreras';

    protected $fillable = [
        'nombre',
        'duracion',
        'universidad_id',
    ];

    public function universidad()
    {
        return $this->belongsTo(Universidad::class, 'universidad_id');
    }

    public function jefeCarrera()
    {
        return $this->hasOne(JefeCarrera::class, 'carrera_id');
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'carrera_id');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'carrera_id');
    }
}