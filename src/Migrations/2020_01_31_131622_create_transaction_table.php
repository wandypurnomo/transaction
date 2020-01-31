<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wandxx\Transaction\Constants\PaymentStatus;
use Wandxx\Transaction\Constants\TransactionStatus;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("code")->unique();
            $table->unsignedTinyInteger("status")->default(TransactionStatus::CART);
            $table->unsignedTinyInteger("payment_status")->default(PaymentStatus::UNPAID);
            $table->json("metadata")->nullable();
            $table->uuid("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
