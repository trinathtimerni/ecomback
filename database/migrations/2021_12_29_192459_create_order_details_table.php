<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->float('price');
            $table->float('tax')->default(0)->nullable();
            $table->integer('quantity');
            $table->float('shipping_cost')->default(0)->nullable();
            $table->string('payment_status',50)->default("unpaid")->nullable();
            $table->string('delivery_status',50)->default("pending")->nullable();
            $table->string('shipping_type',50)->nullable();
            $table->string('product_referal_code',191)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
