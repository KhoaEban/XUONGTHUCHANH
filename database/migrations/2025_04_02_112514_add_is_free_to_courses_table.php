<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('courses', 'is_free')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_free')->default(0);
            });
        }
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('is_free');
        });
    }
};
