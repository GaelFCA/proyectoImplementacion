<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Materia;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Datos base de alumnos (cada alumno pertenece a una sola carrera)
        $alumnosData = [
            [
                'numero_cuenta' => '322001045',
                'nombre' => 'Leonardo',
                'a_paterno' => 'Lechuga',
                'a_materno' => 'Arellano',
                'creditos' => 160,
                'semestre' => 3,
                'regularidad' => true,
                'carrera_id' => 1, // Licenciatura en Informática
                // N:M Condiciones: [1 => Regular, 4 => Movilidad Estudiantil]
                'condiciones' => [1, 4],
                // N:M Materias: [1 => Diseño de Algoritmos, 2 => Programación, 5 => Optativa iOS]
                'materias' => [1, 2, 5],
            ],
            [
                'numero_cuenta' => '322004812',
                'nombre' => 'Santiago',
                'a_paterno' => 'Galicia',
                'a_materno' => 'Romahn',
                'creditos' => 160,
                'semestre' => 3,
                'regularidad' => true,
                'carrera_id' => 1, // Licenciatura en Informática
                // N:M Condiciones: [1 => Regular]
                'condiciones' => [1],
                // N:M Materias: [2 => Programación, 3 => Infraestructura Informática]
                'materias' => [2, 3],
            ],
            [
                'numero_cuenta' => '320567431',
                'nombre' => 'Gabriela',
                'a_paterno' => 'Pacheco',
                'a_materno' => 'Galvez',
                'creditos' => 112,
                'semestre' => 2,
                'regularidad' => false,
                'carrera_id' => 3, // Licenciatura en Contaduría
                // N:M Condiciones: [2 => Irregular, 5 => Artículo 22 (RGI)]
                'condiciones' => [2, 5],
                // N:M Materias: Materia 5 es Optativa de carrera 1 (permitida inter-carrera)
                'materias' => [5],
            ],
            [
                'numero_cuenta' => '319876543',
                'nombre' => 'Fernanda',
                'a_paterno' => 'Lozano',
                'a_materno' => 'Cruz',
                'creditos' => 310,
                'semestre' => 6,
                'regularidad' => true,
                'carrera_id' => 1, // Licenciatura en Informática
                // N:M Condiciones: [1 => Regular, 6 => Egresado]
                'condiciones' => [1, 6],
                // N:M Materias: [4 => Telecomunicaciones II, 5 => Optativa iOS]
                'materias' => [4, 5],
            ],
            [
                'numero_cuenta' => '321009876',
                'nombre' => 'Alejandro',
                'a_paterno' => 'Navarro',
                'a_materno' => 'Peña',
                'creditos' => 190,
                'semestre' => 4,
                'regularidad' => true,
                'carrera_id' => 4, // Licenciatura en Negocios Internacionales
                // N:M Condiciones: [1 => Regular]
                'condiciones' => [1],
                // N:M Materias: Materia 5 es Optativa de carrera 1 (permitida inter-carrera)
                'materias' => [5],
            ],
        ];

        foreach ($alumnosData as $data) {
            $condicionesIds = $data['condiciones'];
            $materiasIds = $data['materias'];
            unset($data['condiciones'], $data['materias']);

            $alumno = Alumno::create($data);

            // Asignar condiciones (N:M)
            $alumno->condiciones()->attach($condicionesIds);

            // Validar e inscribir materias respetando la regla:
            // "El alumno puede inscribir materias de carreras distintas, siempre y cuando sean optativas"
            foreach ($materiasIds as $materiaId) {
                $materia = Materia::find($materiaId);
                if ($materia && $alumno->puedeInscribirMateria($materia)) {
                    $alumno->materias()->attach($materia->id);
                }
            }
        }
    }
}
