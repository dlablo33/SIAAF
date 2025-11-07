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
        Schema::create('articulo_patrimonio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('marca_id');
            $table->string('modelo');
            $table->string('series');
            $table->unsignedInteger('año');
            $table->string('dimensiones');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

        Schema::table('articulo_patrimonio', function ($table) {
            $table->foreign('marca_id')->references('id')->on('cat_marca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_patrimonio');
    }
};
