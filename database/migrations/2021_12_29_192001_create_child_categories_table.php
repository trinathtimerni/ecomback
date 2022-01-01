<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('name');
            $table->string('slug',255)->nullable();
            $table->string('image',255)->nullable();
            $table->text('filter_name')->nullable();
            $table->longText('filter_description')->nullable();
            $table->longText('specification')->nullable();
            $table->tinyInteger('sample')->default(0)->nullable();
            $table->string('status')->default(1)->nullable();
            $table->timestamps();
            $table->foreign('subcategory_id')
                    ->references('id')->on('sub_categories')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_categories');
    }
}
