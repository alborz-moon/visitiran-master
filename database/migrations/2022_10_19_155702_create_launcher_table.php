<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLauncherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('launchers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(false);
            $table->unsignedInteger('user_id');
            $table->string('user_NID')->length(10);
            $table->string('user_email');
            $table->string('user_birth_day');
            $table->unsignedFloat('rate')->nullable();
            $table->unsignedInteger('seen')->default(0);
            $table->unsignedMediumInteger('rate_count')->default(0);
            $table->unsignedMediumInteger('comment_count')->default(0);
            $table->unsignedMediumInteger('new_comment_count')->default(0);
            $table->longText('about')->nullable();
            $table->enum('launcher_type', ['haghighi', 'hoghoghi'])->default('hoghoghi');
            $table->string('company_name')->nullable();
            $table->string('company_type')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('code')->nullable();
            $table->string('img')->nullable();
            $table->string('alt')->nullable();
            $table->mediumText('digest')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->mediumText('seo_tags')->nullable();
            $table->string('launcher_address')->nullable();
            $table->unsignedInteger('launcher_city_id')->nullable();
            $table->string('launcher_email')->nullable();
            $table->string('launcher_site')->nullable();
            $table->string('launcher_phone')->nullable();
            $table->float('launcher_x')->nullable();
            $table->float('launcher_y')->nullable();
            $table->string('company_newspaper')->nullable();
            $table->string('company_last_changes')->nullable();
            $table->string('user_NID_card')->nullable();
            $table->index('launcher_city_id');
            $table->index('user_id');
            $table->foreign('launcher_city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('miras.users');
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
        Schema::connection('mysql2')->dropIfExists('launchers');
    }
}
