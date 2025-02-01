<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trees', function (Blueprint $table) {
            $table->unsignedBigInteger('cp_id')->nullable()->after('user_id'); // Добавляем поле cp_id (это центральная персона)
            $table->foreign('cp_id')->references('id')->on('persons')->onDelete('set null'); // Внешний ключ
        });
    }

    public function down()
    {
        Schema::table('trees', function (Blueprint $table) {
            $table->dropForeign(['cp_id']); // Удаляем внешний ключ
            $table->dropColumn('cp_id'); // Удаляем поле
        });
    }
};
