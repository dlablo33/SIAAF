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
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedBigInteger('tipo_id');
            $table->string('razon');
            $table->unsignedInteger('periodo');
            $table->unsignedInteger('fecha');
            $table->unsignedInteger('minutos');
            $table->string('obvervaciones');
            $table->boolean('autorizacion');
            $table->unsignedBigInteger('permiso_historial_id');
            $table->timestamps();
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('tipo_id')->references('id')->on('cat_permiso_tipo');
        });

        Schema::table('permiso_solicitud', function ($table) {
            $table->foreign('permiso_historial_id')->references('id')->on('permiso_historial');
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
