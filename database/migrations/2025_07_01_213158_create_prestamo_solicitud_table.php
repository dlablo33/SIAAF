<<?php

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
        Schema::create('prestamo_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->date('fecha_solicitud');
            $table->unsignedInteger('periodo');
            $table->unsignedInteger('monto_pedido');
            $table->unsignedBigInteger('prestamo_id');
            $table->timestamps();
        });

        Schema::table('prestamo_sol', function ($table) {
            $table->foreign('empleado_id')->references('id')->on('prestamo');
        });

        Schema::table('prestamo_sol', function ($table) {
            $table->foreign('prestamo_id')->references('id')->on('prestamo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo_sol');
    }
};
