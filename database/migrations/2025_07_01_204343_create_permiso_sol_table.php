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
        Schema::create('permiso_sol', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('empleado_id');
            $table->unsignedInteger('tipo_id');
            $table->string('razon');
            $table->unsignedInteger('periodo');
            $table->unsignedInteger('fecha');
            $table->unsignedInteger('minutos');
            $table->string('obvervaciones');
            $table->boolean('autorizacion');
            $table->unsignedInteger('permiso_id');
            $table->timestamps();
        });

        Schema::table('permiso_sol', function ($table) {
            $table->foreign('empleado_id')->references('id')->on('empleado');
        });

        Schema::table('permiso_sol', function ($table) {
            $table->foreign('tipo_id')->references('id')->on('cat_permiso_tipo');
        });

        Schema::table('permiso_sol', function ($table) {
            $table->foreign('permiso_id')->references('id')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_sol');
    }
};
