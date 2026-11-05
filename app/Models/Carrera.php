<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrera extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'duracion',
        'universidad_id',
    ];

    // Relación con la tabla UNIVERSIDADES[cite: 24]
    public function universidad(): BelongsTo
    {
        return $this->belongsTo(Universidad::class);
    }
}