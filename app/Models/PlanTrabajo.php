<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTrabajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planes_trabajo';

    protected $fillable = [
        'descripcion',
        'url',
    ];

    
    public function materia(): HasOne
    {
        return $this->hasOne(Materia::class, 'plan_trabajo_id');
    }
}
