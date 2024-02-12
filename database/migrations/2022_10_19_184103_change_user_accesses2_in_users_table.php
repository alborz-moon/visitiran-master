<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserAccesses2InUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('level', 
                [
                    User::$ADMIN_LEVEL, User::$EDITOR_LEVEL, User::$REPORT_LEVEL,
                    User::$USER_LEVEL, User::$NEWS_LEVEL, User::$FINANCE_LEVEL,
                    User::$LAUNCHER_LEVEL
                ]
            )->default(User::$USER_LEVEL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
}
