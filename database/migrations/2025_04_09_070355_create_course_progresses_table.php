<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();
    
            // Add any other relevant columns here
            $table->unique(['user_id', 'course_id']); // Ensure a user can only have one progress record per course
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('course_progresses');
    }
};
