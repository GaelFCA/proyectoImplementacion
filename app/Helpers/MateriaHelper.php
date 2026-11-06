<?php

namespace App\Helpers;

class MateriaHelper
{
    /**
     * Tipos de materia disponibles en el formulario.
     * En la base de datos la columna "tipo" sigue siendo texto libre.
     */
    public static function tipos(): array
    {
        return [
            'Obligatoria' => 'Obligatoria',
            'Optativa' => 'Optativa',
            'Optativa Profesionalizante' => 'Optativa Profesionalizante',
        ];
    }
}

