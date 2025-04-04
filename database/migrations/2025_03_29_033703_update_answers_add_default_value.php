<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->string('answer_text')->default('Đáp án mặc định')->change();
        });
    }

    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->string('answer_text')->change();
        });
    }
};
