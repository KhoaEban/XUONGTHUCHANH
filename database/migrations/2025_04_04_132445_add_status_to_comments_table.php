<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'status')) {
                $table->enum('status', ['active', 'pending', 'spam', 'deleted'])->default('pending');
            }
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
