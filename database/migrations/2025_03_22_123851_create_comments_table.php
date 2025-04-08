<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->enum('status', ['visible', 'hidden'])->default('visible');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
