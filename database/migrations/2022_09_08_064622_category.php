<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('img')->nullable();
            $table->string('alt')->nullable();
            $table->string('digest')->nullable();
            $table->string('keywords')->nullable();
            $table->string('tags')->nullable();
            $table->unsignedInteger('priority');
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('visibility')->default(true);
            $table->boolean('show_in_first_page')->default(false);
            $table->boolean('show_items_in_first_page')->default(false);
            $table->index('parent_id');
            $table->foreign('parent_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
