<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'numero_cuenta'; //indica cual es la llave primaria
    public $incrementing = false; //desactiva autoincremento
    protected $keyType = 'string'; // indica que la llave no es entero 

    protected $fillable = [
        'numero_cuenta',
        'nombre',
        'a_paterno',
        'a_materno',
        'creditos',
        'semestre',
        'regularidad',
        'materia_id',
        'condicion_id',
        'carrera_id',
    ];

    protected $casts = [
        'regularidad' => 'boolean',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function condicion()
    {
        return $this->belongsTo(Condicion::class, 'condicion_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}