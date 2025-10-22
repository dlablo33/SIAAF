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
        Schema::create('articulo_responsable', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('almacen_id');
            $table->unsignedBigInteger('empleados_id');
            $table->date('fecha_asignacion');
            $table->string('color');
            $table->unsignedInteger('año');
            $table->text('descripcion');
            $table->timestamps();
        });

        Schema::table('articulo_responsable', function ($table) {
            $table->foreign('tipo_id')->references('id')->on('cat_tipo');
        });

        Schema::table('articulo_responsable', function ($table) {
            $table->foreign('departamento_id')->references('id')->on('cat_departamento');
        });

        Schema::table('articulo_responsable', function ($table) {
            $table->foreign('almacen_id')->references('id')->on('cat_almacen');
        });

        Schema::table('articulo_responsable', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_responsable');
    }
};
