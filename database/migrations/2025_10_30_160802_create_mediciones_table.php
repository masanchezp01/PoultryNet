<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mediciones', function (Blueprint $table) {
            $table->id();
            $table->timestamp('hora')->useCurrent();
            $table->decimal('humedad_iot', 5, 2);
            $table->decimal('temp_iot', 5, 2);
            $table->decimal('humedad_fisica', 5, 2)->nullable();
            $table->decimal('temp_fisica', 5, 2)->nullable();
            $table->decimal('precision_hum', 5, 2)->nullable();
            $table->decimal('precision_temp', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mediciones');
    }
};
