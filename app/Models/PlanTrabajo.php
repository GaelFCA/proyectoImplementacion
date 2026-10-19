<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 


class PlanTrabajo extends Model
{
    protected $table = 'planes_trabajo';

    protected $fillable = [
        'descripcion',
        'url',
    ];

    public function materias()
    {
        return $this->hasMany(Materia::class, 'plan_trabajo_id');
    }
}