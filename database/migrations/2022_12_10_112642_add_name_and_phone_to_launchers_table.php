<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndPhoneToLaunchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('launchers', function (Blueprint $table) {
        //    $table->string('first_name');
        //    $table->string('last_name');
        //    $table->string('phone')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('launchers', function (Blueprint $table) {
        //    $table->dropColumn('first_name');
        //    $table->dropColumn('last_name');
        //    $table->dropUnique(['phone']);
        //    $table->dropColumn('phone');
        });
    }
}
