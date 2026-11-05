<?php

namespace App\Helpers;

class UniversidadHelper
{
    /**
     * Tipos de universidad disponibles en el formulario.
     * En la base de datos la columna "tipo" sigue siendo texto libre.
     */
    public static function tipos(): array
    {
        return [
            'Pública' => 'Pública',
            'Privada' => 'Privada',
        ];
    }
}

