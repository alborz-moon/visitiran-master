<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusPhaseInLaunchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('launchers', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::connection('mysql2')->table('events', function (Blueprint $table) {
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
        Schema::connection('mysql2')->table('launchers', function (Blueprint $table) {
            $table->boolean('status')->default(false);
        });

        Schema::connection('mysql2')->table('events', function (Blueprint $table) {
            $table->boolean('status')->default(false);
        });
    }
}
