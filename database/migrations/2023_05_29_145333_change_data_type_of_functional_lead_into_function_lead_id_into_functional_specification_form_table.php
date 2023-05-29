<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfFunctionalLeadIntoFunctionLeadIdIntoFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->renameColumn('functional_lead', 'functional_lead_id');

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
            $table->renameColumn('functional_lead_id', 'functional_lead');

        });
    }
}
