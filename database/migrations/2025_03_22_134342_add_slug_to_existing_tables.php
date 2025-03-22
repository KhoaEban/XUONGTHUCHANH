<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        $tables = [
            'categories', 'courses', 'users', 'enrollments', 'comments', 
            'lessons', 'questions', 'quizzes', 'quiz_results', 
            'answers', 'certificates', 'payments'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('slug')->unique(); // ✅ Loại bỏ `->after('name')`
            });
        }
    }

    public function down()
    {
        $tables = [
            'categories', 'courses', 'users', 'enrollments', 'comments', 
            'lessons', 'questions', 'quizzes', 'quiz_results', 
            'answers', 'certificates', 'payments'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
