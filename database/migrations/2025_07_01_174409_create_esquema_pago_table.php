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
            $table->unsignedBigInteger('empleado_id');
            $table->string('tipo');
            $table->unsignedInteger('sueldo');
            $table->unsignedInteger('bono_puntualidad');
            $table->unsignedInteger('bono_asistencia');
            $table->unsignedInteger('despensa');
            $table->unsignedInteger('septimo');
            $table->unsignedInteger('total_sem');
            $table->unsignedInteger('mensual_ant');
            $table->timestamps();
        });

        Schema::table('esquema_pago', function ($table) {
            $table->foreign('empleado_id')->references('id')->on('empleado');
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
