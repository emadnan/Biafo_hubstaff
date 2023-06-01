<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeadLineIntoFsfAssignToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fsf_assign_to_users', function (Blueprint $table) {
            $table->dateTime('dead_line')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fsf_assign_to_users', function (Blueprint $table) {
            $table->dropColumn('dead_line');
        });
    }
}
