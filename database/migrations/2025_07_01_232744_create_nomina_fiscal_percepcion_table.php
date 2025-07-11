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
        Schema::create('nomina_fiscal_percepcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedInteger('suelo');
            $table->unsignedInteger('septimo');
            $table->unsignedInteger('bono_puntualidad');
            $table->unsignedInteger('bono_asistencia');
            $table->unsignedInteger('bono_despensa');
            $table->unsignedInteger('bono_extra');
            $table->unsignedInteger('vacaciones');
            $table->unsignedInteger('prima_vac');
            $table->unsignedInteger('devoluciones');
            $table->unsignedInteger('vac_dias');
            $table->unsignedInteger('vac_pagados');
            $table->unsignedInteger('vac_gozados');
            $table->unsignedInteger('total');
            $table->timestamps();
        });

        Schema::table('nomina_fiscal_percepcion', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomina_fiscal_percepcion');
    }
};
