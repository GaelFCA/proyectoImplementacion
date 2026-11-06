<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use SoftDeletes;

    protected $table = 'carreras';

    protected $fillable = [
        'nombre',
        'duracion',
        'universidad_id',
    ];

    public function universidad(): BelongsTo
    {
        return $this->belongsTo(Universidad::class, 'universidad_id');
    }

    public function jefeCarrera(): HasOne
    {
        return $this->hasOne(JefeCarrera::class, 'carrera_id');
    }

    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class, 'carrera_id');
    }

    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class, 'carrera_id');
    }
}
