<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Universidad extends Model
{
    protected $table = 'universidades';

    protected $fillable = [
        'nombre_universidad',
        'estado_convenio',
        'pais',
        'ciudad',
        'tipo',
    ];

    //convierte el estado convenio a booleano cuando lo recibes 
    protected $casts = [
        'estado_convenio' => 'boolean',
    ];

    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'universidad_id');
    }
}