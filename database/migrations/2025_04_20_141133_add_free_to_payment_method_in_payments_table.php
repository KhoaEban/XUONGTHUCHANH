<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFreeToPaymentMethodInPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method ENUM('credit_card', 'momo', 'vnpay', 'free') NOT NULL");
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method ENUM('credit_card', 'momo', 'vnpay') NOT NULL");
        });
    }
}