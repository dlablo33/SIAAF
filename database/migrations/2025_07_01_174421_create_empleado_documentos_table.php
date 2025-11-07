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
        Schema::create('empleado_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_documento');
            $table->string('path');
            $table->date('fecha_alta');
            $table->date('fecha_expiracion');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

        Schema::table('empleado_documentos', function ($table) {
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });

        Schema::table('empleado_documentos', function ($table) {
            $table->foreign('id_documento')->references('id')->on('cat_documentos');
        });

        Schema::table('empleado_documentos', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_documentos');
    }
};
