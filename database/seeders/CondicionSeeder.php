<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Condicion;

class CondicionSeeder extends Seeder
{
    public function run(): void
    {
        $condiciones = [
            ['nombre' => 'Regular', 'descripcion' => 'Alumno al corriente con las asignaturas de su semestre según el plan de estudios.'],
            ['nombre' => 'Irregular', 'descripcion' => 'Alumno con asignaturas no acreditadas o desfasadas de su semestre curricular.'],
            ['nombre' => 'Suspensión Temporal', 'descripcion' => 'Baja temporal autorizada por el H. Consejo Técnico hasta por dos semestres (Art. 23 RGI).'],
            ['nombre' => 'Movilidad Estudiantil', 'descripcion' => 'Alumno cursando semestre de intercambio nacional o internacional vía DGECI / FCA.'],
            ['nombre' => 'Artículo 22 (RGI)', 'descripcion' => 'Alumno que excedió el límite de tiempo para estar inscrito y acredita vía exámenes extraordinarios.'],
            ['nombre' => 'Egresado', 'descripcion' => 'Alumno que ha cubierto el 100% de los créditos y se encuentra en proceso de titulación.'],
        ];

        foreach ($condiciones as $cond) {
            Condicion::create($cond);
        }
    }
}