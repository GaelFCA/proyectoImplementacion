<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coordinador;

class CoordinadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coordinador::create([
            'numero_trabajador' => '840901', 
            'nombre' => 'Mitzi Jaqueline',
            'a_paterno' => 'Gomez', 
            'a_materno' => 'Morales'
        ]);
    }
}
