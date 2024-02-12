<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->length(11);
            $table->enum('role', ['student', 'teacher', 'advisor'])->default('student');
            $table->longText('bio')->nullable();
            $table->index('city_id');
            $table->foreign('city_id')->references('id')->on('events.cities');
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
        Schema::dropIfExists('forms');
    }
}
