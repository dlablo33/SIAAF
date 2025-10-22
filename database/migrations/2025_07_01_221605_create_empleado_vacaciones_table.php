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
        Schema::create('empleado_vacaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedInteger('vacaciones_ley');
            $table->unsignedInteger('vacaciones_restantes');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
        });

        Schema::table('empleado_vacaciones', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('empleado_vacaciones', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });;

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_vacaciones');
    }
};
