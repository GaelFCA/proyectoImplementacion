<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    use SoftDeletes;

    protected $table = 'alumnos';
    protected $primaryKey = 'numero_cuenta'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

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

    
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'alumno_materia', 'alumno_numero_cuenta', 'materia_id')
            ->withTimestamps();
    }

   
    public function condiciones(): BelongsToMany
    {
        return $this->belongsToMany(Condicion::class, 'alumno_condicion', 'alumno_numero_cuenta', 'condicion_id')
            ->withTimestamps();
    }


    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    /**
     * Valida si el alumno puede inscribir una materia :
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
