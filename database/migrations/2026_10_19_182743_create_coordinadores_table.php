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
        Schema::create('coordinadores', function (Blueprint $table) {
            $table->string('numero_trabajador',6)->primary();
            $table->string('nombre',40);
            $table->string('a_paterno',20);
            $table->string('a_materno',20);
            $table->timestamps();
            $table->unique(['nombre', 'a_paterno', 'a_materno'], 'coordinador_nombre_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinadores');
    }
};
