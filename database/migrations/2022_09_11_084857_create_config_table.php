<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('can_pay_cash')->default(false);
            $table->longText('desc_default')->nullable();
            $table->tinyInteger('sell_list_period')->default(7);
            $table->tinyInteger('seen_list_period')->default(7);
            $table->tinyInteger('home_banner_limit')->default(2);
            $table->tinyInteger('detail_banner_limit')->default(1);
            $table->tinyInteger('list_banner_limit')->default(1);
            $table->tinyInteger('critical_point')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
