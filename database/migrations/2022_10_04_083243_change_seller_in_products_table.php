<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSellerInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('seller');
            $table->dropColumn('seller_logo');
            $table->dropColumn('seller_alt');
            $table->unsignedInteger('seller_id')->nullable();
            $table->index('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('seller')->nullable();
            $table->string('seller_logo')->nullable();
            $table->string('seller_alt')->nullable();
            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
        });
    }
}
