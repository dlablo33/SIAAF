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
        Schema::create('cat_domicilio', function (Blueprint $table) {
            $table->id();
            $table->string('calle');
            $table->unsignedInteger('numero');
            $table->unsignedInteger('numero_interior');
            $table->string('colonia');
            $table->unsignedInteger('codigo_postal');
            $table->string('municipio');
            $table->string('estado');
            $table->unsignedBigInteger('id_estatus');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });

        Schema::table('cat_domicilio', function ($table) {
            $table->foreign('id_estatus')->references('id')->on('cat_estatus');
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_domicilio');
    }
};
