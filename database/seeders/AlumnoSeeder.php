<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = [
            [
                'numero_cuenta' => '322001045',
                'nombre' => 'Leonardo',
                'a_paterno' => 'Lechuga',
                'a_materno' => 'Arellano',
                'creditos' => 160,
                'semestre' => 3,
                'regularidad' => true,
                'materia_id' => 2,   
                'condicion_id' => 1,
                'carrera_id' => 1,    
            ],
            [
                'numero_cuenta' => '322004812',
                'nombre' => 'Santiago',
                'a_paterno' => 'Galicia',
                'a_materno' => 'Romahn',
                'creditos' => 160,
                'semestre' => 3,
                'regularidad' => true,
                'materia_id' => 3,   
                'condicion_id' => 1,  
                'carrera_id' => 1,    
            ],
            [
                'numero_cuenta' => '320567431',
                'nombre' => 'Diego',
                'a_paterno' => 'Castillo',
                'a_materno' => 'Vargas',
                'creditos' => 112,
                'semestre' => 2,
                'regularidad' => false,
                'materia_id' => 6,    
                'condicion_id' => 2, 
                'carrera_id' => 3,   
            ],
            [
                'numero_cuenta' => '319876543',
                'nombre' => 'Fernanda',
                'a_paterno' => 'Lozano',
                'a_materno' => 'Cruz',
                'creditos' => 310,
                'semestre' => 6,
                'regularidad' => true,
                'materia_id' => 1,    
                'condicion_id' => 1,  
                'carrera_id' => 1,    
            ],
            [
                'numero_cuenta' => '321009876',
                'nombre' => 'Alejandro',
                'a_paterno' => 'Navarro',
                'a_materno' => 'Peña',
                'creditos' => 190,
                'semestre' => 4,
                'regularidad' => true,
                'materia_id' => 6,   
                'condicion_id' => 1, 
                'carrera_id' => 4,    
            ],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }
    }
}