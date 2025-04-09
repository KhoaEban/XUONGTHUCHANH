<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_progresses', function (Blueprint $table) {
            $table->json('completed_lessons')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('course_progresses', function (Blueprint $table) {
            $table->dropColumn('completed_lessons');
        });
    }
};