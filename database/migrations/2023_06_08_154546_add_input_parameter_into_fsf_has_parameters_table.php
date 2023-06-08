<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputParameterIntoFsfHasParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fsf_has_parameters', function (Blueprint $table) {
            $table->string('input_parameter_name')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fsf_has_parameters', function (Blueprint $table) {
            $table->dropColumn('input_parameter_name');
        });
    }
}
