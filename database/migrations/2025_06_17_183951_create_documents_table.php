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
Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->enum('category', ['license', 'official_seal', 'provisional', 'other']);
    $table->date('issue_date');
    $table->date('expiration_date');
    $table->boolean('is_valid')->default(true);
    $table->foreignId('client_id')->constrained()->onDelete('cascade');
    $table->string('file_path');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
