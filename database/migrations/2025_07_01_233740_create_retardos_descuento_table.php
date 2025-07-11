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
        Schema::create('retardos_descuento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedInteger('nomina_diferencia_bono');
            $table->unsignedInteger('nomina_retardo');
            $table->unsignedInteger('complemento_diferencia_bono');
            $table->unsignedInteger('complemento_retardo');
            $table->timestamps();
        });

        Schema::table('retardos_descuento', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retardos_descuento');
    }
};
