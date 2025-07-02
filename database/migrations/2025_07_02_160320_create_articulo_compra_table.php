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
        Schema::create('articulo_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_id');
            $table->string('nombre');
            $table->unsignedBigInteger('marca_id');
            $table->string('stock');
            $table->unsignedBigInteger('medida_id');
            $table->timestamps();
        });

        Schema::table('articulo_compra', function ($table) {
            $table->foreign('tipo_id')->references('id')->on('cat_tipo');
        });

        Schema::table('articulo_compra', function ($table) {
            $table->foreign('marca_id')->references('id')->on('cat_marca');
        });

        Schema::table('articulo_compra', function ($table) {
            $table->foreign('medida_id')->references('id')->on('cat_medida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_compra');
    }
};
