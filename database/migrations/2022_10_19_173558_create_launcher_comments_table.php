<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLauncherCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('launcher_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('launcher_id');
            $table->unsignedSmallInteger('rate');
            $table->string('msg')->nullable();
            $table->boolean('is_bookmark')->nullable();
            $table->string('positive')->nullable();
            $table->string('negative')->nullable();
            $table->boolean('status')->default(false);
            $table->index('launcher_id');
            $table->foreign('launcher_id')->references('id')->on('launchers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('launcher_comments');
    }
}
