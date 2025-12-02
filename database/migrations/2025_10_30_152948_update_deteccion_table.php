<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deteccion', function (Blueprint $table) {
            // Agregar la columna nueva (si no existe)
            if (!Schema::hasColumn('deteccion', 'registro_ambiental_id')) {
                $table->foreignId('registro_ambiental_id')
                    ->nullable()
                    ->constrained('registros_ambientales')
                    ->nullOnDelete()
                    ->after('sector_id');
            }

            // Modificar columnas existentes
            $table->decimal('confianza', 5, 2)->change();
            $table->decimal('tiempo_deteccion', 6, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('deteccion', function (Blueprint $table) {
            // Solo eliminar la columna si existe
            if (Schema::hasColumn('deteccion', 'registro_ambiental_id')) {
                $table->dropConstrainedForeignId('registro_ambiental_id');
            }
        });
    }
};
