<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnsIntoChangeRequestSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_request_summary', function (Blueprint $table) {
            $table->string('crf_title')->after('crf_id');
            $table->enum('type_of_requirement', ['Change', 'Enhancement', 'Error_rectification'])->after('Technical_resource');
            $table->enum('priority', ['High', 'Medium','Low'])->after('type_of_requirement');
            $table->enum('with_in_project_scope', ['Yes', 'No'])->after('priority');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_request_summary', function (Blueprint $table) {
            $table->dropColumn('crf_title');
            $table->dropColumn('type_of_requirement');
            $table->dropColumn('priority');
            $table->dropColumn('with_in_project_scope');

        });
    }
}
