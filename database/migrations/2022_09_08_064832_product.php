<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('digest')->nullable();
            $table->string('keywords')->nullable();
            $table->string('tags')->nullable();
            $table->longText('description');
            $table->string('seller')->nullable();
            $table->string('seller_logo')->nullable();
            $table->string('seller_alt')->nullable();
            $table->unsignedInteger('rate')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('seen')->default(0);
            $table->tinyInteger('priority');
            $table->tinyInteger('available_count')->default(0);
            $table->unsignedInteger('off')->nullable();
            $table->enum('off_type', ['value', 'percent'])->nullable();
            $table->timestamp('off_expiration')->nullable();
            $table->boolean('visibility')->default(true);
            $table->boolean('is_in_top_list')->default(false);
            $table->string('img');
            $table->string('alt')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
            $table->string('similars')->nullable();
            $table->index('category_id');
            $table->index('brand_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
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
