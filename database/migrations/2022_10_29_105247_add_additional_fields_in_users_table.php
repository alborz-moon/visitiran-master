<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nid')->length(10)->nullable()->unique();
            $table->string('mail')->nullable()->unique();
            $table->string('birth_day')->length(10)->nullable();
            $table->enum('payment_back', ['WALLET', 'ONLINE'])->default('WALLET');
            $table->string('shaba_no')->length(19)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nid']);
            $table->dropUnique(['mail']);
            $table->dropColumn('nid');
            $table->dropColumn('mail');
            $table->dropColumn('birth_day');
            $table->dropColumn('payment_back');
            $table->dropColumn('shaba_no');
        });
    }
}
