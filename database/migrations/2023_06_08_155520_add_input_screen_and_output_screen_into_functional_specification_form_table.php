<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputScreenAndOutputScreenIntoFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->integer('reference_id')->after('id');
            $table->string('input_screen')->after('development_logic')->nullable();
            $table->string('output_screen')->after('input_screen')->nullable();
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
            $table->dropColumn('reference_id');
            $table->dropColumn('input_screen');
            $table->dropColumn('output_screen');
        });
    }
}
