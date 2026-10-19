<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            ['nombre' => 'Diseño de Algoritmos', 'semestre' => 1, 'tipo' => 'Obligatoria', 'plan_trabajo_id' => 1, 'carrera_id' => 1],
            ['nombre' => 'Programación', 'semestre' => 2, 'tipo' => 'Obligatoria', 'plan_trabajo_id' => 1, 'carrera_id' => 1],
            ['nombre' => 'Infraestructura Informática', 'semestre' => 2, 'tipo' => 'Obligatoria', 'plan_trabajo_id' => 1, 'carrera_id' => 1],
            ['nombre' => 'Telecomunicaciones II', 'semestre' => 6, 'tipo' => 'Obligatoria', 'plan_trabajo_id' => 3, 'carrera_id' => 1],
            ['nombre' => 'Desarrollo de Aplicaciones para Dispositivos iOS', 'semestre' => 6, 'tipo' => 'Optativa Profesionalizante', 'plan_trabajo_id' => 1, 'carrera_id' => 1],
            ['nombre' => 'Principios y Técnicas de Investigación', 'semestre' => 1, 'tipo' => 'Obligatoria', 'plan_trabajo_id' => 2, 'carrera_id' => 2],
        ];

        foreach ($materias as $mat) {
            Materia::create($mat);
        }
    }
}