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
        Schema::create('esquema_deducciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_deducciones');
            $table->string('tipo');
            $table->unsignedInteger('cantidad');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
        });

        Schema::table('esquema_deducciones', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('esquema_deducciones', function ($table) {
            $table->foreign('id_deducciones')->references('id')->on('cat_deducciones');
        });

        Schema::table('esquema_deducciones', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esquema_deducciones');
    }
};
