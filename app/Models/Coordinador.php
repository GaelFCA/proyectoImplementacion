<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';
    protected $primaryKey = 'numero_trabajador';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_trabajador',
        'nombre',
        'a_paterno',
        'a_materno',
    ];

    /**
     * Obtiene el coordinador único del sistema.
     */
    public static function getCoordinadorGeneral(): ?self
    {
        return static::query()->first();
    }
}
