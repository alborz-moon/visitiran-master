<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('category_feature_id');
            $table->string('value');
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('available_count')->nullable();
            $table->index('product_id');
            $table->index('category_feature_id');
            $table->unique(['product_id', 'category_feature_id']);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_feature_id')->references('id')->on('category_features');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_features');
    }
}
