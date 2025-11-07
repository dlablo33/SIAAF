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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('a_paterno');
            $table->string('a_materno');
            $table->string('correo_interno')->unique()->nullable();
            $table->string('correo_personal')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nss')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('genero')->nullable();
            $table->unsignedBigInteger('id_domicilio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('contacto')->nullable();
            $table->string('contacto_telefono')->nullable();
            $table->unsignedBigInteger('id_empresa');
            $table->string('id_puesto')->nullable();
            $table->date('fecha_ingreso');
            $table->date('fecha_baja')->nullable();
            $table->date('fecha_reingreso')->nullable();
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado');
    }
};
