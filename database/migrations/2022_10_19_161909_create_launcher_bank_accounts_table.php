<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLauncherBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('launcher_bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('launcher_id');
            $table->string('shaba_no')->length(19);
            $table->boolean('status')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->index('launcher_id');
            $table->foreign('launcher_id')->references('id')->on('launchers');
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
        Schema::connection('mysql2')->dropIfExists('launcher_bank_accounts');
    }
}
