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
        Schema::create('retardos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedInteger('periodo');
            $table->unsignedInteger('lunes');
            $table->unsignedInteger('martes');
            $table->unsignedInteger('miercoles');
            $table->unsignedInteger('jueves');
            $table->unsignedInteger('viernes');
            $table->unsignedInteger('total');
            $table->unsignedBigInteger('retardos_descuento_id');
            $table->timestamps();
        });

        Schema::table('retardos', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });

        Schema::table('retardos', function ($table) {
            $table->foreign('retardos_descuento_id')->references('id')->on('retardos_descuento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retardos');
    }
};
