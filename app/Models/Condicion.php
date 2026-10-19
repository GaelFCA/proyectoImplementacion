<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    protected $table = 'condiciones';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'condicion_id');
    }
}