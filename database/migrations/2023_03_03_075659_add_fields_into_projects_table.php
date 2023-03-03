<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsIntoProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('team_id')->after('company_id');
            $table->integer('budget')->after('project_name');
            $table->enum('to_dos',array('Y', 'N'))->default('N')->after('dead_line');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('team_id');
            $table->dropColumn('budget');
            $table->dropColumn('to_dos');
        });
    }
}
