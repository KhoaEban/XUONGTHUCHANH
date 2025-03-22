<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->timestamp('enrolled_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};
