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
        Schema::create('papeleria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id');
            $table->string('comprobante_domicilio');
            $table->string('ine');
            $table->string('nss');
            $table->string('curp');
            $table->string('constancia');
            $table->string('kardex');
            $table->string('titulo_ced');
            $table->string('acta_nacimiento');
            $table->string('cv');
            $table->timestamps();
        });

        Schema::table('papeleria', function ($table) {
            $table->foreign('empleados_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papeleria');
    }
};
