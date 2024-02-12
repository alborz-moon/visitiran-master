<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('money_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('launcher_bank_account_id');
            $table->unsignedInteger('amount');
            $table->string('additional')->nullable();
            $table->boolean('seen')->default(false);
            $table->enum('status', ['pending', 'rejected', 'paid', 'confirmed']);
            $table->timestamps();
            $table->index('user_id');
            $table->index('launcher_bank_account_id');
            $table->foreign('user_id')->on('miras.users')->references('id');
            $table->foreign('launcher_bank_account_id')->on('launcher_bank_accounts')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('money_requests');
    }
}
