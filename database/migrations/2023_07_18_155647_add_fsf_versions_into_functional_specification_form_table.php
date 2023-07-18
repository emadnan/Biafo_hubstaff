<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFsfVersionsIntoFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->string('fsf_version')->after('description');
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
            $table->dropColumn('fsf_version');
        });
    }
}
