<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerAndBrandToOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offs', function (Blueprint $table) {

            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            
            $table->index('brand_id');
            $table->index('seller_id');

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('seller_id')->references('id')->on('sellers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offs', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
            $table->dropColumn('brand_id');
        });
    }
}
