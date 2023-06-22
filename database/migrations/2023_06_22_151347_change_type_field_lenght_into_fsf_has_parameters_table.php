<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeFieldLenghtIntoFsfHasParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fsf_has_parameters', function (Blueprint $table) {
            $table->integer('field_length')->change();
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
            $table->string('field_length')->change();
        });
    }
}
