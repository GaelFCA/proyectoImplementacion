<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Universidad;

class UniversidadSeeder extends Seeder
{
    public function run(): void
    {
        $universidades = [
            ['nombre_universidad' => 'Universidad Nacional Autónoma de México', 'estado_convenio' => true, 'pais' => 'México', 'ciudad' => 'Ciudad de México', 'tipo' => 'Pública'],
            ['nombre_universidad' => 'Instituto Politécnico Nacional', 'estado_convenio' => true, 'pais' => 'México', 'ciudad' => 'Ciudad de México', 'tipo' => 'Pública'],
            ['nombre_universidad' => 'Universidad Autónoma Metropolitana', 'estado_convenio' => false, 'pais' => 'México', 'ciudad' => 'Ciudad de México', 'tipo' => 'Pública'],
            ['nombre_universidad' => 'Universidad de Guadalajara', 'estado_convenio' => true, 'pais' => 'México', 'ciudad' => 'Guadalajara', 'tipo' => 'Pública'],
            ['nombre_universidad' => 'Tecnológico de Complutense de Madrid', 'estado_convenio' => true, 'pais' => 'España', 'ciudad' => 'Madrid', 'tipo' => 'Privada'],
            ['nombre_universidad' => 'Universidad Iberoamericana', 'estado_convenio' => false, 'pais' => 'México', 'ciudad' => 'Ciudad de México', 'tipo' => 'Privada'],
        ];

        foreach ($universidades as $uni) { //se usa para no tener que escribir muchas veces el create por separado $uni es la variable temporal para recorrer el arreglo
            Universidad::create($uni);
        }
    }
}