<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamLeadAdnDepartmentIntoTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('team_lead_id')->after('id')->nullable();
            $table->integer('department_id')->after('team_lead_id');
            $table->dropColumn('team_company_id');
            $table->integer('company_id')->after('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('team_lead_id');
            $table->dropColumn('department_id');
            $table->integer('team_company_id')->after('id');
            $table->dropColumn('company_id');
        });
    }
}
