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
        Schema::create('esquema_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->string('tipo');
            $table->unsignedInteger('sueldo');
            $table->unsignedInteger('bono_puntualidad');
            $table->unsignedInteger('bono_asistencia');
            $table->unsignedInteger('despensa');
            $table->unsignedInteger('septimo_dia');
            $table->unsignedInteger('total_sem');
            $table->unsignedInteger('mensual_anticipado');
            $table->timestamps();
        });

        Schema::table('esquema_pago', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esquema_pago');
    }
};
