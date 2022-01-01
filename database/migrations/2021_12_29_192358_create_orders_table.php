<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->BigInteger('guest_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('shipping_address')->nullable();
            $table->double('total');
            $table->double('discount')->default(0)->nullable();
            $table->string('payment_status',50)->default("unpaid")->nullable();
            $table->string('payment_type',191)->nullable();
            $table->text('payment_details')->nullable();
            $table->string('code',191)->nullable();
            $table->date('date');
            $table->tinyInteger('viewed')->default(0)->nullable();
            $table->tinyInteger('delivery_status_viewed')->default(0)->nullable();
            $table->tinyInteger('payment_status_viewed')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
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
