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
        Schema::create('sugerencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('empleado_id');
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::table('sugerencias', function ($table) {
            $table->foreign('empleado_id')->references('id')->on('empleado');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sugerencias');
    }
};
