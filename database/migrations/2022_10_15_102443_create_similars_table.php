<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('sim_1')->nullable();
            $table->unsignedInteger('sim_2')->nullable();
            $table->unsignedInteger('sim_3')->nullable();
            $table->unsignedInteger('sim_4')->nullable();
            $table->unsignedInteger('sim_5')->nullable();
            $table->unsignedInteger('sim_6')->nullable();
            $table->unsignedInteger('sim_7')->nullable();
            $table->unsignedInteger('sim_8')->nullable();
            $table->index('product_id');
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('similars');
    }
}
