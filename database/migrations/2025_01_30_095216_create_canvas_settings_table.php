<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('canvas_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('width')->default(800);
            $table->integer('height')->default(600);
            $table->integer('vertical_margin')->default(10);
            $table->integer('horizontal_margin')->default(10);
            $table->timestamps();
        });

        // Создадим единственную запись
        \Illuminate\Support\Facades\DB::table('canvas_settings')->insert([
            'width' => 216,
            'height' => 96,
            'vertical_margin' => 48,
            'horizontal_margin' => 48,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('canvas_settings');
    }
};
