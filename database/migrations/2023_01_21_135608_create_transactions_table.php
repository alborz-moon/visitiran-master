<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('transaction_code')->nullable();
            $table->string('tracking_code')->nullable();
            $table->enum('status', ['init', 'cancelled', 'completed']);
            $table->enum('site', ['shop', 'event'])->default('shop');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('transfer')->default(0);
            $table->unsignedInteger('ref_id')->nullable();
            $table->unsignedInteger('off_id')->nullable();
            $table->unsignedInteger('off_amount')->nullable();
            $table->longText('additional')->nullable();
            $table->index('user_id');
            $table->index('ref_id');
            $table->index('off_id');
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
        Schema::dropIfExists('transactions');
    }
}
