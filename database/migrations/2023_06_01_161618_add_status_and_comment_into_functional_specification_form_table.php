<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndCommentIntoFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('functional_specification_form', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'InProgress', 'Completed'])->default('Pending')->after('dead_line');
            $table->string('comment')->after('status');
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
            $table->dropColumn('status');
            $table->dropColumn('comment');
        });
    }
}
