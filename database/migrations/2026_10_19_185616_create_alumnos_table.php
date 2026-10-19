<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->string('numero_cuenta',9)->primary();
            $table->string('nombre', 20);
            $table->string('a_paterno', 20);
            $table->string('a_materno', 20);
            $table->integer('creditos');
            $table->integer('semestre');
            $table->boolean('regularidad')->default(true);
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('condicion_id')->constrained('condiciones');
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->timestamps();

            $table->unique(['nombre', 'a_paterno', 'a_materno'], 'alumno_nombre_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
