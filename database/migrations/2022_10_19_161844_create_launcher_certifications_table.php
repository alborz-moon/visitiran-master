<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLauncherCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('launcher_certifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('launcher_id');
            $table->string('file');
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
        Schema::connection('mysql2')->dropIfExists('launcher_certifications');
    }
}
