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
        Schema::create('permiso_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedInteger('periodo');
            $table->unsignedInteger('lunes');
            $table->unsignedInteger('martes');
            $table->unsignedInteger('miercoles');
            $table->unsignedInteger('jueves');
            $table->unsignedInteger('viernes');
            $table->unsignedInteger('total');
            $table->unsignedInteger('ajuste_nomina');
            $table->unsignedInteger('ajuste_complemento');
            $table->timestamps();
        });

        Schema::table('permiso_historial', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_historial');
    }
};
