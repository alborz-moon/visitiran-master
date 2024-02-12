<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeShaba24DigitInLauncherBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('launcher_bank_accounts', function (Blueprint $table) {
            $table->string('shaba_no')->length(24)->change();
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('launcher_bank_accounts', function (Blueprint $table) {
            $table->string('shaba_no')->length(19)->change();
            $table->boolean('status')->default(false);
        });
    }
}
