<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;
use App\Models\Universidad;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $universidades = Universidad::all();

        $carreras = [
            ['nombre' => 'Licenciatura en Informática', 'duracion' => 8, 'universidad_id' => 1],
            ['nombre' => 'Licenciatura en Administración', 'duracion' => 8, 'universidad_id' => 1],
            ['nombre' => 'Licenciatura en Contaduría', 'duracion' => 8, 'universidad_id' => 1],
            ['nombre' => 'Licenciatura en Negocios Internacionales', 'duracion' => 8, 'universidad_id' => 1],
        ];

        foreach ($carreras as $carrera) {
            Carrera::create($carrera);
        }
    }
}