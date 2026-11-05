<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
use Illuminate\Database\Eloquent\Relations\HasOne;
>>>>>>> feature/Carreras
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTrabajo extends Model
{
<<<<<<< HEAD
    use HasFactory, SoftDeletes;

=======
    use SoftDeletes;
>>>>>>> feature/Carreras
    protected $table = 'planes_trabajo';

    protected $fillable = [
        'descripcion',
        'url',
    ];
}