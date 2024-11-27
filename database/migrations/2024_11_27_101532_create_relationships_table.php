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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_one_id')->constrained('people')->onDelete('cascade'); // Первый человек
            $table->foreignId('person_two_id')->constrained('people')->onDelete('cascade'); // Второй человек
            $table->string('type'); // Тип связи (например, "родитель", "супруг", "брат", "сестра")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
