<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueUserInEventBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('event_buyers', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'user_id']);
            $table->dropColumn('paid');
            $table->integer('unit_price');
            $table->bigInteger('created_ts');
            $table->enum('status', ['paid', 'pending']);
            $table->unsignedInteger('transaction_id');
            $table->index('transaction_id');
            $table->foreign('transaction_id')->on('miras2.transactions')->references('id')->onDelete('cascade')
                ->onUpdate('cascade');
            // $table->foreign('user_id')->on('miras2.users')->references('id')->onDelete('cascade')
            //     ->onUpdate('cascade');
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
            $table->unique(['event_id', 'user_id']);
            $table->integer('paid');
            $table->dropColumn('unit_price');
            $table->dropColumn('status');
            $table->dropColumn('created_ts');
            $table->dropForeign(['transaction_id']);
            // $table->dropForeign(['user_id']);
            $table->dropColumn('transaction_id');
        });
    }
}
