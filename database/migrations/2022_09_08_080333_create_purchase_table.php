<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('off_id')->nullable();
            $table->string('tracking_code')->unique();
            $table->enum('status', ['finalized', 'sending', 'delivered']);
            $table->enum('payment_type', ['cach', 'online']);
            $table->timestamps();
            $table->index('user_id');
            $table->index('off_id');
            $table->foreign('off_id')->references('id')->on('offs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
