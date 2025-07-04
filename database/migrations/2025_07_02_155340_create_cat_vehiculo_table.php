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
        Schema::create('cat_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('placa');
            $table->string('niv');
            $table->string('marca_id');
            $table->string('modelo');
            $table->string('año');
            $table->string('color');
            $table->string('tipo');
            $table->timestamps();
        });

        Schema::table('cat_vehiculo', function ($table) {
            $table->foreign('marca_id')->references('id')->on('cat_marca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_vehiculo');
    }
};
