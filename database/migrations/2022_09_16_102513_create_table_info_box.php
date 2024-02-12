<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInfoBox extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_box', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_large');
            $table->string('img_mid')->nullable();
            $table->string('img_small')->nullable();
            $table->string('href')->nullable();
            $table->string('alt')->nullable();
            $table->enum('collapse_from', ['right', 'left', 'center'])->default('right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_box');
    }
}
