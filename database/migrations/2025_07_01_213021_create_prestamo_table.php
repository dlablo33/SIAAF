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
            $table->unsignedBigInteger('id_empleado');
            $table->string('tipo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->unsignedInteger('pago_periodo');
            $table->unsignedInteger('total');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
        });

        Schema::table('prestamo', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('prestamo', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
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
