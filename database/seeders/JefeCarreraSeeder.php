<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JefeCarrera;
use App\Models\Carrera;

class JefeCarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = Carrera::all();

        $jefes = [
            ['numero_trabajador' => '750101', 'nombre' => 'Gabriel', 'a_paterno' => 'Guevara', 'a_materno' => 'Gutiérrez', 'carrera_id' => 1],
            ['numero_trabajador' => '750102', 'nombre' => 'Silvia Berenice', 'a_paterno' => 'Villamil', 'a_materno' => 'Rodríguez', 'carrera_id' => 2],
            ['numero_trabajador' => '750103', 'nombre' => 'María Gloria', 'a_paterno' => 'Arévalo', 'a_materno' => 'Guerrero', 'carrera_id' => 3],
            ['numero_trabajador' => '750104', 'nombre' => 'Hugo Javier', 'a_paterno' => 'Buenrostro', 'a_materno' => 'Aguilar', 'carrera_id' => 4],
        ];
        foreach ($jefes as $jefe) {
            JefeCarrera::create($jefe);
        }
    }
}