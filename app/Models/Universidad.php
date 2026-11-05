<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universidad extends Model
{
    use SoftDeletes;

    protected $table = 'universidades';

    protected $fillable = [
        'nombre_universidad',
        'estado_convenio',
        'pais',
        'ciudad',
        'tipo',
    ];

    
    protected $casts = [
        'estado_convenio' => 'boolean',
    ];

    public function carreras(): HasMany
    {
        return $this->hasMany(Carrera::class, 'universidad_id');
    }
}
