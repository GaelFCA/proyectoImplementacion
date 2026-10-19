<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Universidad;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Condicion;
use App\Models\JefeCarrera;
use App\Models\Materia;
use App\Models\PlanTrabajo;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            UniversidadSeeder::class,
            PlanTrabajoSeeder::class,
            CondicionSeeder::class,
            CoordinadorSeeder::class,
            CarreraSeeder::class,
            JefeCarreraSeeder::class,
            MateriaSeeder::class,
            AlumnoSeeder::class,
        ]);
    }
}
