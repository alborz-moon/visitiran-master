<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropColumn('tracking_code');
            $table->dropForeign(['off_id']);
            $table->dropColumn('off_id');
            $table->enum('payment_status', ['paid', 'pending']);
            $table->unsignedInteger('transaction_id');
            $table->string('delivery');
            $table->index('transaction_id');
            $table->foreign('transaction_id')->on('transactions')->references('id')->onDelete('cascade')->onUpdate('cascade');
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
            $table->string('tracking_code');
            $table->unsignedInteger('off_id');
            $table->index('off_id');
            $table->foreign('off_id')->on('offs')->references('id');
            $table->dropColumn('payment_status');
            $table->dropColumn('delivery');
            $table->dropForeign(['transaction_id']);
            $table->dropColumn('transaction_id');
        });
        
    }
}
