<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanTrabajo;

class PlanTrabajoSeeder extends Seeder
{
    public function run(): void
    {
        // Un plan de trabajo por cada materia (relación 1:1)
        $planes = [
            [
                'descripcion' => 'Plan de Trabajo: Diseño de Algoritmos - Lógica computacional, diagramas de flujo y estructuras de control.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/algoritmos',
            ],
            [
                'descripcion' => 'Plan de Trabajo: Programación - Paradigma orientado a objetos, estructuras de datos y buenas prácticas.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/programacion',
            ],
            [
                'descripcion' => 'Plan de Trabajo: Infraestructura Informática - Hardware, sistemas operativos, virtualización y servidores.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/infraestructura',
            ],
            [
                'descripcion' => 'Plan de Trabajo: Telecomunicaciones II - Redes avanzadas, protocolos de ruteo y conmutación convergente.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/telecomunicaciones2',
            ],
            [
                'descripcion' => 'Plan de Trabajo: Desarrollo de Aplicaciones para Dispositivos iOS - Desarrollo móvil nativo con Swift, SwiftUI y APIs REST.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/ios',
            ],
            [
                'descripcion' => 'Plan de Trabajo: Principios y Técnicas de Investigación - Métodos cuantitativos y cualitativos aplicados a las ciencias administrativas.',
                'url' => 'https://licenciaturas.fca.unam.mx/planes/investigacion',
            ],
        ];

        foreach ($planes as $plan) {
            PlanTrabajo::create($plan);
        }
    }
}
