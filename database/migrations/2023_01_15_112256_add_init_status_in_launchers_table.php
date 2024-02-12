<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddInitStatusInLaunchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE events.launchers MODIFY status ENUM('pending','confirmed','rejected', 'init') default 'init'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('launchers', function (Blueprint $table) {
            DB::statement("ALTER TABLE events.launchers MODIFY status ENUM('pending','confirmed','rejected') default 'pending'");
        });
    }
}
