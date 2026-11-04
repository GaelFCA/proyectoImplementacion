<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlanTrabajo extends Model
{
    protected $table = 'planes_trabajo';

    protected $fillable = [
        'descripcion',
        'url',
    ];

    /**
     * Relación 1 a 1 con Materia.
     */
    public function materia(): HasOne
    {
        return $this->hasOne(Materia::class, 'plan_trabajo_id');
    }
}
