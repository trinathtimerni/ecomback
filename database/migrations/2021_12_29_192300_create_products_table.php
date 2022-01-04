<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("product_id");
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("subcategory_id")->nullable();
            $table->unsignedBigInteger("childcategory_id")->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->string('name',255);
            $table->string('short_description',255)->nullable();
            $table->longText('description');
            $table->string('main_image');
            $table->double('price');
            $table->string('unit_id')->nullable();
            $table->double('previous_price')->nullable();
            $table->double('quantity');
            $table->integer('review')->max(5)->nullable();
            $table->double('discount')->default(0)->nullable();
            $table->text('colors')->nullable();
            $table->integer('number_of_sale')->nullable();
            $table->integer('minimum_quantity')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('status')->default(1)->nullable()->comment('1=> Active, 0 =>Inactive');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('childcategory_id')->references('id')->on('child_categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
