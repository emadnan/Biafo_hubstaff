<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFunctionalIdIntoChangeRequestFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_request_forms', function (Blueprint $table) {
            $table->integer('functional_id')->after('project_manager');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_request_forms', function (Blueprint $table) {
            $table->dropColumn('functional_id');
        });
    }
}
