<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JefeCarrera extends Model
{
    protected $table = 'jefe_carreras'; // dice a que tbla hace referencia daba error por poner carreras en plural 
    protected $primaryKey = 'numero_trabajador'; // indica cual es la llave primaria porqu eno se uso id 
    public $incrementing = false; //desactiva autoincremento
    protected $keyType = 'string'; // indica que la llave no es entero 

    protected $fillable = [
        'numero_trabajador',
        'nombre',
        'carrera_id',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}