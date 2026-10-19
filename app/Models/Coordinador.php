<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';
    protected $primaryKey = 'numero_trabajador';
    public $incrementing = false;

    protected $fillable = [
        'numero_trabajador',
        'nombre',
        'a_paterno',
        'a_materno',
    ];
}