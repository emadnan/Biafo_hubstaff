<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserProjectIdsAndStartEndTimeIntoStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->integer('user_id')->after('company_id');
            $table->integer('project_id')->after('user_id');
            $table->dateTime('start_time')->after('stream_name');
            $table->dateTime('end_time')->after('start_time');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('project_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}
