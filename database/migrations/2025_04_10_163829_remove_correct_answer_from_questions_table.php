<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCorrectAnswerFromQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('correct_answer');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('correct_answer')->nullable(); // Khôi phục nếu cần
        });
    }
}
