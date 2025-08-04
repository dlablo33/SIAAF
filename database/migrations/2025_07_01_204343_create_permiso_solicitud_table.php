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
        Schema::create('permiso_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_tipo');
            $table->string('razon');
            $table->date('fecha');
            $table->unsignedInteger('tiempo');
            $table->string('obvervaciones');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('id_tipo')->references('id')->on('cat_permiso_tipo');
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_solicitud');
    }
};
