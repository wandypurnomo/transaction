<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("transaction_id");
            $table->string("name");
            $table->integer("quantity", false);
            $table->integer("price", false);
            $table->bigInteger("sub_total", false);
            $table->json("metadata")->nullable();
            $table->timestamps();

            $table->foreign("transaction_id")
                ->references("id")
                ->on("transactions")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
