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
        Schema::create('articulo_compra_historial', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedInteger('presentacion');
            $table->unsignedInteger('contenido');
            $table->unsignedBigInteger('medida_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->date('fecha_compra');
            $table->unsignedInteger('precio');
            $table->unsignedInteger('cantidad');
            $table->timestamps();

            Schema::table('articulo_compra_historial', function ($table) {
                $table->foreign('tipo_id')->references('id')->on('cat_tipo');
            });

            Schema::table('articulo_compra_historial', function ($table) {
                $table->foreign('medida_id')->references('id')->on('cat_tipo');
            });

            Schema::table('articulo_compra_historial', function ($table) {
                $table->foreign('proveedor_id')->references('id')->on('cat_tipo');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_compra_historial');
    }
};
