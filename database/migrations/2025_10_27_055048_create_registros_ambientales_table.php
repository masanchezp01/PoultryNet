<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registros_ambientales', function (Blueprint $table) {
            $table->id();

            // Relación con el sector
            $table->foreignId('sector_id')
                ->constrained('sectores')
                ->onDelete('cascade');

            // Valores medidos en el momento

            // Límites ideales y críticos de mediciones
            $table->decimal('temp_min_ideal', 5, 2)->nullable()->comment('Temperatura mínima ideal');
            $table->decimal('temp_max_ideal', 5, 2)->nullable()->comment('Temperatura máxima ideal');
            $table->decimal('temp_min_critica', 5, 2)->nullable()->comment('Temperatura mínima crítica');
            $table->decimal('temp_max_critica', 5, 2)->nullable()->comment('Temperatura máxima crítica');

            // Límites ideales y críticos de humedad
            $table->decimal('humedad_min_ideal', 5, 2)->nullable()->comment('Humedad mínima ideal');
            $table->decimal('humedad_max_ideal', 5, 2)->nullable()->comment('Humedad máxima ideal');
            $table->decimal('humedad_min_critica', 5, 2)->nullable()->comment('Humedad mínima crítica');
            $table->decimal('humedad_max_critica', 5, 2)->nullable()->comment('Humedad máxima crítica');



            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_ambientales');
    }
};
