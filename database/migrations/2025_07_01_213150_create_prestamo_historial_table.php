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
        Schema::create('prestamo_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prestamo');
            $table->date('fecha');
            $table->unsignedInteger('pago');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

        Schema::table('prestamo_historial', function ($table) {
            $table->foreign('id_prestamo')->references('id')->on('prestamo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo_historial');
    }
};
