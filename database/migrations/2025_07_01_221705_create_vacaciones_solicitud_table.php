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
        Schema::create('vacaciones_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado_vacaciones');
            $table->string('concepto');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->double('prima');
            $table->text('observaciones');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

        Schema::table('vacaciones_solicitud', function ($table) {
            $table->foreign('id_empleado_vacaciones')->references('id')->on('empleado_vacaciones');
        });

        Schema::table('vacaciones_solicitud', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones_solicitud');
    }
};
