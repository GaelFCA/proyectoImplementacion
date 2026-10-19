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
        Schema::create('jefe_carreras', function (Blueprint $table) {
            $table->string('numero_trabajador',6)->primary;
            $table->string('nombre', 20);
            $table->string('a_paterno',20);
            $table->string('a_materno',20);
            $table->foreignId('carrera_id')->unique()->constrained('carreras');
            $table->timestamps();

            $table->unique(['nombre', 'a_paterno', 'a_materno'], 'jefes_carreras_nombre_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jefe_carreras');
    }
};
