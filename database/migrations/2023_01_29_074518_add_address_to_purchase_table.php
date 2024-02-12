<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropColumn('address_id');
            $table->unsignedInteger('city_id');
            $table->longText('address');
            $table->string('postal_code');
            $table->double('x');
            $table->double('y');
            $table->string('recv_name');
            $table->string('recv_phone', 11);
            $table->index('city_id');
            $table->foreign('city_id')->on('events.cities')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase', function (Blueprint $table) {
            
            $table->unsignedInteger('address_id');

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->dropColumn('address');
            $table->dropColumn('postal_code');
            $table->dropColumn('x');
            $table->dropColumn('y');
            $table->dropColumn('recv_name');
            $table->dropColumn('recv_phone');
        });
    }
}
