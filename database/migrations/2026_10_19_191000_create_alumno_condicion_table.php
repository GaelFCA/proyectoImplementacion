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
        Schema::create('alumno_condicion', function (Blueprint $table) {
            $table->id();
            $table->string('alumno_numero_cuenta', 9);
            $table->foreignId('condicion_id')->constrained('condiciones')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('alumno_numero_cuenta')
                ->references('numero_cuenta')
                ->on('alumnos')
                ->cascadeOnDelete();

            $table->unique(['alumno_numero_cuenta', 'condicion_id'], 'alumno_condicion_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_condicion');
    }
};

