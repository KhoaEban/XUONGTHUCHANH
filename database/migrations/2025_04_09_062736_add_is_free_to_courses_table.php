<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFreeToCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'is_free')) {
                $table->boolean('is_free')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'is_free')) {
                $table->dropColumn('is_free');
            }
        });
    }
}
