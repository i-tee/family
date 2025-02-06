<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->boolean('gender')->nullable()->after('death_date');
        });
    }
    
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
    
};
