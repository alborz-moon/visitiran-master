<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('event_buyers', function (Blueprint $table) {

            $table->id('id');

            $table->unsignedInteger('event_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('paid');
            
            $table->index('event_id');
            $table->index('user_id');

            $table->unique(['event_id', 'user_id']);

            $table->foreign('event_id')->on('events.events')->references('id');
            $table->foreign('user_id')->on('miras.users')->references('id');
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
        Schema::connection('mysql2')->dropIfExists('event_buyers');
    }
}
