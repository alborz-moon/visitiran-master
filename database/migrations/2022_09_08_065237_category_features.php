<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('show_in_top')->default(false);
            $table->boolean('effect_on_price')->default(false);
            $table->boolean('effect_on_available_count')->default(false);
            $table->string('unit')->nullable();
            $table->string('choices')->nullable();
            $table->unsignedInteger('priority');
            $table->enum('answer_type', ['number', 'text', 'longtext', 'multi_choice'])->default('text');
            $table->unsignedInteger('category_id');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_features');
    }
}
