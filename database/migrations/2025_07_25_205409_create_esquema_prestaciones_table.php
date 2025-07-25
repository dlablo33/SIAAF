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
        Schema::create('esquema_prestaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->string('tipo');
            $table->unsignedBigInteger('id_prestaciones');
            $table->unsignedInteger('cantidad');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
        });

        Schema::table('esquema_prestaciones', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('esquema_prestaciones', function ($table) {
            $table->foreign('id_prestaciones')->references('id')->on('cat_prestaciones');
        });

        Schema::table('esquema_prestaciones', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('id_estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esquema_prestaciones');
    }
};
