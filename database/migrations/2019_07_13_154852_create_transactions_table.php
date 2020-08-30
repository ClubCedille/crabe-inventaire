<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->timestamps();
            $table->string('statusCode');
            $table->string('status');
            $table->string('orderId');
            $table->string('intent');
            $table->string('capture_id')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('paypal_fee')->nullable();
            $table->string('payer_id')->nullable();
            $table->text('products');
            $table->integer('total');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->engine = 'InnoDB';
            
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
