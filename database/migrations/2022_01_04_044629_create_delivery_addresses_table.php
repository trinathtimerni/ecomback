<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("first_name",191);
            $table->string("last_name",191);
            $table->string("email",191);
            $table->string("title",191)->nullable();
            $table->string("country_code",191)->nullable();
            $table->string("phone",20);
            $table->integer("country")->nullable();
            $table->text("address")->nullable();
            $table->text("address1")->nullable();
            $table->string("house_no",191)->nullable();
            $table->string("city",191)->nullable();
            $table->integer("post_code")->nullable();
            $table->tinyInteger("status")->default(0);
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
        Schema::dropIfExists('delivery_addresses');
    }
}
