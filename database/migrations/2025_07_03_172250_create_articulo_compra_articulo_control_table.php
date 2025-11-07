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
        Schema::create('articulo_compra_control', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('articulo_compra_id');
            $table->unsignedInteger('cantidad');
            $table->unsignedBigInteger('medida_id');
            $table->timestamps();
        });

        Schema::table('articulo_compra_control', function ($table) {
            $table->foreign('articulo_compra_id')->references('id')->on('articulo_compra');
        });

        Schema::table('articulo_compra_control', function ($table) {
            $table->foreign('medida_id')->references('id')->on('cat_medida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_compra_control');
    }
};
