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
            $table->integer('project_id')->after('company_id')->nullable();
            $table->dateTime('start_time')->after('stream_name')->nullable();
            $table->dateTime('end_time')->after('start_time')->nullable();

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
            $table->dropColumn('project_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}
