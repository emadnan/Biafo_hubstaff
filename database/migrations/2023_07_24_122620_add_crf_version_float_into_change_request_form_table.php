<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCrfVersionFloatIntoChangeRequestFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_request_forms', function (Blueprint $table) {
            $table->integer('crf_version_float')->after('crf_version');
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
            $table->dropColumn('crf_version_float');
        });
    }
}
