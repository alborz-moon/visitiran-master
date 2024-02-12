<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsInAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->double('x');
            $table->double('y');
            $table->unsignedInteger('city_id');
            $table->string('recv_name');
            $table->string('recv_last_name');
            $table->string('recv_phone');
            $table->index('city_id');
            $table->foreign('city_id')->references('id')->on('events.cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->dropColumn('recv_name');
            $table->dropColumn('recv_last_name');
            $table->dropColumn('recv_phone');
            $table->dropColumn('x');
            $table->dropColumn('y');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
}
