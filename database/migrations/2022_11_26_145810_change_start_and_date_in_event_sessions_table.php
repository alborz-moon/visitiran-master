<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStartAndDateInEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('event_sessions', function (Blueprint $table) {
            $table->string('start')->length(20)->change();
            $table->string('end')->length(20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('event_sessions', function (Blueprint $table) {
            $table->timestamp('start')->change();
            $table->timestamp('end')->change();
        });
    }
}
