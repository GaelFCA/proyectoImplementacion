<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JefeCarrera extends Model
{
    use SoftDeletes;

    protected $table = 'jefe_carreras'; 
    protected $primaryKey = 'numero_trabajador'; 
    public $incrementing = false;
    protected $keyType = 'string'; 

    protected $fillable = [
        'numero_trabajador',
        'nombre',
        'a_paterno',
        'a_materno',
        'carrera_id',
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}
