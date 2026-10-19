<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanTrabajo;

class PlanTrabajoSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'descripcion' => 'Plan de Estudios Licenciatura en Informática (FCA Plan 2023)',
                'url' => 'https://licenciaturas.fca.unam.mx/'
            ],
            [
                'descripcion' => 'Plan de Estudios Licenciatura en Administración (FCA Plan 2023)',
                'url' => 'https://licenciaturas.fca.unam.mx'
            ],
            [
                'descripcion' => 'Plan de Estudios Licenciatura en Contaduría (FCA Plan 2023)',
                'url' => 'https://licenciaturas.fca.unam.mx'
            ],
            [
                'descripcion' => 'Plan de Estudios Licenciatura en Negocios Internacionales (FCA)',
                'url' => 'https://licenciaturas.fca.unam.mx'
            ]
        ];

        foreach ($planes as $plan) {
            PlanTrabajo::create($plan);
        }
    }
}