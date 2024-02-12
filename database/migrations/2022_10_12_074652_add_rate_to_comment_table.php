<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateToCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->longText('msg')->nullable()->change();
            $table->tinyInteger('rate')->nullable();
            $table->boolean('is_bookmark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->longText('msg')->change();
            $table->dropColumn('rate');
            $table->dropColumn('is_bookmark');
        });
    }
}
