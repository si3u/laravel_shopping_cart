<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('full_name');
            $table->char('email');
            $table->char('tel');
            $table->text('address');
            $table->integer('delivery_method');
            $table->integer('payment_method');
            $table->boolean('read_status')->default(false);
            $table->boolean('order_status')->nullable();
            $table->float('full_price')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
