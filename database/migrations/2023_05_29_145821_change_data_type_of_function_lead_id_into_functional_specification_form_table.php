<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfFunctionLeadIdIntoFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->integer('functional_lead_id')->change();
            $table->integer('team_lead_id')->after('functional_lead_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->integer('functional_lead_id')->change();
            $table->dropColumn('team_lead_id');

        });
    }
}
