<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNullableFieldsInEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('events', function (Blueprint $table) {
            $table->unsignedInteger('start_registry')->nullable()->change();
            $table->unsignedInteger('end_registry')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->unsignedInteger('price')->nullable()->change();
            $table->string('language');
            $table->string('link')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('site')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->float('x')->nullable()->change();
            $table->float('y')->nullable()->change();
            $table->unsignedInteger('city_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('events', function (Blueprint $table) {
            $table->unsignedInteger('start_registry')->change();
            $table->unsignedInteger('end_registry')->change();
            $table->longText('description')->change();
            $table->unsignedInteger('price')->change();
            $table->dropColumn('language')->change();
            $table->dropColumn('link');
            $table->dropColumn('postal_code');
            $table->string('address')->change();
            $table->string('email')->change();
            $table->string('site')->change();
            $table->string('phone')->change();
            $table->float('x')->change();
            $table->float('y')->change();
            $table->unsignedInteger('city_id')->change();
        });
    }
}
