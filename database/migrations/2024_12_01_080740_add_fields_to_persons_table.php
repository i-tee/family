<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPersonsTable extends Migration
{
    public function up(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('last_name'); // Отчество
            $table->date('birth_date')->nullable()->after('middle_name'); // Дата рождения
            $table->date('death_date')->nullable()->after('birth_date'); // Дата смерти
        });
    }

    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn(['middle_name', 'birth_date', 'death_date']);
        });
    }
}
