<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoFieldsInEventBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('event_buyers', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->length(11);
            $table->string('nid')->length(10);
            $table->unsignedSmallInteger('count')->default(1);
            $table->unsignedInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('event_buyers', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('nid');
            $table->dropColumn('count');
            $table->unsignedInteger('user_id')->change();
        });
    }
}
