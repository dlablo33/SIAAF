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
        Schema::create('prestamo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->string('tipo');
            $table->unsignedInteger('periodo_inicio');
            $table->unsignedInteger('periodo_fin');
            $table->unsignedInteger('periodos_pagados');
            $table->unsignedInteger('periodos_faltantes');
            $table->unsignedInteger('pago_periodo');
            $table->unsignedInteger('total_pagado');
            $table->unsignedInteger('total');
            $table->timestamps();
        });

        Schema::table('prestamo', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
